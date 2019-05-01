<?php

namespace App\Http\Controllers;

Use App\Parkir;
Use App\Tarif;
Use App\ParkirKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerParkir extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $parkiran = DB::select('SELECT * FROM `parkir_masuk` WHERE NOT EXISTS(SELECT * FROM parkir_keluar WHERE parkir_masuk.id = parkir_keluar.id) ORDER BY jam_masuk DESC');
        $no = 1;
        return view('layouts.data_parkiran_masuk',['data'=>$parkiran,'no'=>$no]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_kendaraan = Tarif::all();
        
        $date = date('Y-m-d');
        return view('layouts.input_kendaraan',['automatic_date'=>$date,'jenis_kendaraan'=>$jenis_kendaraan]);
    }
    public function findTarif(Request $request){
        $tarif = Tarif::select('tarif')->where('jenis_kendaraan',$request->jenis_kendaraan)->first();
        return response()->json($tarif);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         date_default_timezone_set('Asia/Jakarta');
        $jam_masuk = date('H:i:s');

         $this->validate(request(),[
            'no_polisi' => 'required|max:7',
            'jenis_kendaraan' => 'required',
            'tarif' => 'required',
            'tgl_masuk' => 'required'
        ]);

         $parkir = Parkir::create([
            'plat_nomor' => strtoupper($request->no_polisi),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'jam_masuk' => $jam_masuk,
            'tgl_masuk' => $request->tgl_masuk
         ]);
         return redirect('/transaksi/DataParkiranMasuk')->with('message','Berhasil Input Kendaraan ');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $parkir = Parkir::find($id);
       $tarif = DB::table('tarif')->where('jenis_kendaraan','=',$parkir->jenis_kendaraan)->first();

        $tahun = substr($parkir->tgl_masuk,0,4);
        $bulan = substr($parkir->tgl_masuk,4,4);
        $hari = substr($parkir->tgl_masuk,8,8);

        $tgl = $hari.$bulan.$tahun;

       return view('layouts.struk_parkir',['data'=>$parkir,'tarif'=>$tarif,'tgl'=>$tgl]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Parkir::find($id);
        return view('layouts.edit_data_masuk',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parkir = Parkir::find($id);

        $this->validate(request(),[
        'plat_nomor' => 'required|max:7',
        'jenis_kendaraan' => 'required'
        ]);

        $data =[
        'plat_nomor' => $request->plat_nomor,
        'jenis_kendaraan' => $request->jenis_kendaraan
        ];

        $parkir->update($data);

        return redirect('/transaksi/DataParkiranMasuk')->with('message','Data Kendaraan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Parkir::destroy($id);
        return redirect('/transaksi /DataParkiranMasuk')->with('message','Data Parkir Berhasil Di Hapus');
    }

    public function search(Request $request){
        $id = $request->cari;

        $hasil = Parkir::where('plat_nomor','Like','%'.$id.'%')->paginate(5);

        return view('layouts.result_cari',['data'=>$hasil]);
    }

    public function selesai($id){
        date_default_timezone_set('Asia/Jakarta');
        $id = Parkir::find($id);

        $harga = Tarif::select('tarif')->where('jenis_kendaraan',$id->jenis_kendaraan)->first();

        $jam_masuk = substr($id->jam_masuk,0,2);

        $jam_keluar = substr(date('H:i:s'),0,2);

        $tanggal_sekarang = date('Y-m-d');

        $tanggal_masuk = $id->tgl_masuk;

        // $menit_masuk = intVal(substr($id->jam_masuk,2,4));

        // $menit_keluar = intVal(substr(date('H:i:s'),2,4));

        // $total_menit =  $menit_keluar - $menit_masuk;
         $total_jam = $jam_keluar - $jam_masuk;
         $tarif = $total_jam * $harga->tarif;
        
        if ($tanggal_sekarang == $tanggal_masuk) {
              if ($total_jam == 0) {
                    $tarif = $harga->tarif;
                }
                else{
                    $tarif = $total_jam * $harga->tarif;
                }
        }
        else{
            $tgl_masuk = strtotime($tanggal_masuk);
            $tgl_keluar = strtotime($tanggal_sekarang);

            $total_tgl = $tgl_keluar - $tgl_masuk ;
            $total_tgl = ($total_tgl/3600)/24;
            $total_tgl = $total_tgl * 24;
            $tarif_tgl = $total_tgl * $harga->tarif;
            $tarif = $tarif + $tarif_tgl;
        }

       
        
        return view('layouts.kendaraan_keluar',['data'=>$id,'tt'=>$tarif,'total_jam'=>$tarif]);
    }

    public function storeSelesai(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $this->validate(request(),[
        'id_parkir' => 'required',
        'no_polisi' => 'required|max:7',
        'jenis_kendaraan' => 'required',
        'total_harga' => 'required',
        'bayar' => 'required',
        'kembalian' => 'required'
        ]);
        $bayar = $request->bayar;
        $total = $request->total_harga;

        if ($bayar < $total) {
            return redirect()->back()->with('message','Uang Tidak Boleh Kurang');
        }
        $jam_keluar = date('H:i:s');
        $tgl_keluar = date('Y:m:d');
        $keluar = ParkirKeluar::create([
         'id' => $request->id_parkir,
         'plat_nomor' => strtoupper($request->no_polisi),
         'jenis_kendaraan' => $request->jenis_kendaraan,
         'jam_keluar' => $jam_keluar,
         'tgl_keluar' => $tgl_keluar,
         'total' => $request->total_harga,
         'bayar' => $request->bayar,
         'kembalian' => $request->kembalian
        ]);

        return redirect('/transaksi/DataParkiranMasuk')->with('message','Input Data Kendaraan Keluar Berhasil');
    }

    public function showKeluar(){
        $data = DB::table('parkir_keluar')->paginate(10);

        return view('layouts.data_parkiran_keluar',['data'=>$data]);
    }

    public function search2(Request $request){
        $id = $request->cari;
        $data = ParkirKeluar::where('plat_nomor','LIKE','%'.$id.'%')->paginate(5);

        return view('layouts.result_cari2',['data'=>$data]);
    }

    public function home(){
       $date = date('Y-m-d');
       $mobil = DB::table('parkir_masuk')->where([
        ['tgl_masuk','=',$date],['jenis_kendaraan','Mobil']
       ])->count('jenis_kendaraan');
       $motor = DB::table('parkir_masuk')->where([
        ['tgl_masuk','=',$date],['jenis_kendaraan','Motor']
       ])->count('jenis_kendaraan');
       $ruang_mobil = DB::table('stok_parkir')->where('jenis_kendaraan','=','Mobil')->first();
       $ruang_motor = DB::table('stok_parkir')->where('jenis_kendaraan','=','Motor')->first();    
       $pendapatan = DB::table('laporan_parkiran')->where('tgl_keluar','=',$date)->sum('total');
        return view('home',['pendapatan'=>$pendapatan,'mobil'=>$mobil,'motor'=>$motor,'r_mobil'=>$ruang_mobil,'r_motor'=>$ruang_motor]);
    }
    
    public function login(){
        return view('auth.login');
    }
}
