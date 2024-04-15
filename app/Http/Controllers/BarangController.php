<?php

namespace App\Http\Controllers;

// import CreateBarangRequest untuk digunakan
use App\Events\BarangCreated;
use App\Events\BarangDeleted;
use App\Http\Requests\CreateBarangRequest;
use App\Jobs\BarangProcessor;
use App\Services\BarangService;
use App\Services\BarangServiceInterface;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    function __construct(private BarangServiceInterface $barangService)
    {
    }

    // List Barang
    function index()
    {
        // NOTE: scoped query, hanya tampilkan seluruh barang dari
        // user bersangkutan
        //
        // NOTE: orderBy mengurutkan data berdasarkan column/field id (asc)
        // https://laravel.com/docs/10.x/queries#ordering-grouping-limit-and-offset
        //
        // NOTE: paginate menghasilkan result data yang dipaginasi
        // https://laravel.com/docs/10.x/pagination
        // ada dua jenis pagination yang bisa dihasilkan langsung oleh Laravel
        // limit offset pagination & cursor pagination
        $barangs = Barang::owned()->orderBy('id')->paginate(5);

        return view('barang.index', ['barangs' => $barangs]);
    }

    // Form new barang
    function new()
    {
        return view('barang.new', ['barang' => new Barang]);
    }

    // Create new barang
    // Inject form request validation CreateBarangRequest ke method
    // create untuk digunakan di method ini
    function create(CreateBarangRequest $request)
    {
        // check apakah authenticated user bisa membuat barang
        $this->authorize('create', Barang::class);

        // jalankan validation, jika validation data, laravel akan
        // menampilkan kembali form request terakhir
        // variable $errors akan diisikan dengan pesan error dari validation
        // Jika validasi berhasil, variable $b akan berisikan data request
        // yang sudah di-validasi dan di-normalize
        $b = $request->validated();

        try {
            $barang = $this->barangService->create($b['nama'], $b['harga'], Auth::user());

            // Publish event
            BarangCreated::dispatch($barang);
        } catch (\Exception $e) {
            Log::error('failed to create barang', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500);
        }

        return to_route('admin.barang.index');
    }

    function show(int $id)
    {
        // findOrFail -> cari berdasarkan primary key, abort(404) jika
        // tidak ditemukan
        $barang = Barang::owned()->findOrFail($id);

        return view('barang.show', ['barang' => $barang]);
    }

    function edit(int $id)
    {
        $barang = Barang::owned()->findOrFail($id);

        return view('barang.edit', ['barang' => $barang]);
    }

    function update(CreateBarangRequest $request, int $id)
    {
        // check apakah authenticated user bisa mengedit barang
        $existingBarang = Barang::owned()->findOrFail($id);
        $this->authorize('update', $existingBarang);

        $validated_request = $request->validated();

        // DB::transaction menjalankan operasi transaction database
        // fungsi ini menerima sebuah callable/anonymous function/closure
        // yang dijalankan di dalam transaksi.
        // keyword use digunakan untuk menginject variable dari luar untuk
        // digunakan di dalam anonymous function
        // Apabila terjadi exception di dalam transaction, transaksi database
        // akan di rollback, sebaliknya jika tidak terjadi exception
        // transaksi akan otomatis di commit ke database
        DB::transaction(function () use ($validated_request, $id) {
            $barang = Barang::owned()->where('id', $id)?->lockForUpdate();
            if (!$barang) {
                abort(404);
            }

            $updated = $barang->update([
                'nama' => $validated_request['nama'],
                'harga' => $validated_request['harga'],
                'updated_by' => Auth::id(),
            ]);
            if (!$updated) {
                abort(500);
            }
        });

        return to_route('admin.barang.index');
    }

    function delete(int $id)
    {
        // check apakah authenticated user dapat menghapus barang
        $existingBarang = Barang::owned()->findOrFail($id);
        $this->authorize('delete', $existingBarang);

        DB::transaction(function () use ($id) {
            $barang = Barang::findOrFail($id);
            BarangDeleted::dispatch($barang);
            $deleted = $barang->delete();
            if (!$deleted) {
                abort(500);
            }

        });

        return to_route('admin.barang.index');
    }
}
