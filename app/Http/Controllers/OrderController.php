<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $order = Order::with('user')->latest();

        if ($request->filled('search')) {
            $order->whereDate('created_at', $request->input('search'));
        }
        // mengambil seluruh data pada table orders dengan pagination perhalaman 10 data serta mengambil hasil data relasi function bernama user pada model Order 
        $orders = $order->paginate(10);
        return view("order.kasir.index", compact("orders"));
    }

    public function clear()
    {
        return redirect()->route('kasir.order.index');
    }

    public function data(Request $request)
    {
        // With: mengambil relasi dari PK dan FK nya. Valuenya == nama func relasi hasMany/belongsTo yang ada di modelnya
        $order = Order::with('user')->latest();

        if ($request->filled('search')) {
            $order->whereDate('created_at', $request->input('search'));
        }

        $orders = $order->simplePaginate(5);
        return view("order.admin.index", compact("orders"));
    }

    public function reset()
    {
        return redirect()->route('order.data');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ]);

        // mencari jumlah item yang sama pada array, strukturnya 
        // ["item" => "jumlah"]
        $arrayDistinct = array_count_values($request->medicines);

        // menyiapkan array kosong untuk menampung format array baru
        $arrayAssocMedicines = [];

        // looping hasil perhitungan item distinct (duplikat)
        // key akan berupa value dr inputan medicines(id), item array berupa jumlah perhitungan item dupilikat
        foreach ($arrayDistinct as $id => $count) {
            // mencari data obat berdasarkan id (obat yang dipilih)
            $medicine = Medicine::where('id', $id)->first();

            // pastikan $medicine tidak null sebelum mengakses propertinya
            if ($medicine) {
                // ambil bagian column price dari hasil pencarian lalu kalikan dengan jumlah item duplikat sehingga akan menghasilkan total harga dr pembelian obat tersebut
                $subPrice = $medicine->price * $count;

                // struktur value column medicines menjadi multidimensi dengan dimensi kedua berbentuk array assoc dengan key "id", "nama_medicine", "qty", "price"
                $arrayItem = [
                    'id' => $id,
                    'name_medicine' => $medicine['name'],
                    'qty' => $count,
                    'price' => $medicine['price'],
                    'sub_price' => $subPrice,
                ];

                // masukan struktur array tersebut ke array kosong yg disediakan sebelumnya
                array_push($arrayAssocMedicines, $arrayItem);
            } else {
                // Tambahkan log atau pesan lainnya jika obat dengan ID tersebut tidak ditemukan
                // atau pertimbangkan bagaimana menangani kasus ini sesuai kebutuhan aplikasi Anda.
            }
        }

        // total harga pembelian dari obat obatan yang dipilih
        $totalPrice = 0;

        // looping format array medicines baru
        foreach ($arrayAssocMedicines as $item) {
            //total harga pembelian ditambahkan dr keseluruhan sub_price data medicine
            $totalPrice += (int)$item['sub_price'];
        }

        // harga beli ditambah 10% ppn
        $priceWithPPN = $totalPrice + ($totalPrice * 0.01);

        //tambah data ke database
        $proses = Order::create([
            //data user_id diambil dari id akun kasur yang sedang login
            'user_id' => Auth::user()->id,
            'medicines' => $arrayAssocMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $priceWithPPN,
        ]);

        if ($proses) {
            // jika proses tambah data berhasil ditambahkan, ambil data order yg dibuat oleh kasir yg sedang login (where), dengan tanggal paling terbaru (orderBy), ambil hanya satu data (first)
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            // kirim data order yang diambil td, bagian column id sebagai parameter path dari route print 
            return redirect()->route('kasir.order.print', $order->id);
        } else {
            // jika tidak berhasil, maka diarhakan kembali ke halaman form dengan pesan pemberitahuan
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian. Silahkan coba kembali dengan data yang sesuai!');
        }
    }

    public function downloadPDF($id)
    {
        // ambil data yang diperlukan, dan pastikan data berformat array
        $order = Order::find($id)->toArray();
        // mengirim inisial variable dari data yang akan digunakan pada layout pdf
        view()->share('order', $order);
        // panggil blade yang akan di download 
        $pdf = PDF::loadView('order.kasir.download-pdf', $order);
        // kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('recepit.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function exportExcel()
    {
        $fill_name = 'data_pembelian' . '.xlsx';
        return Excel::download(new OrdersExport, $fill_name);
    }
}
