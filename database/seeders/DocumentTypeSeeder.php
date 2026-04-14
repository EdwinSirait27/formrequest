<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Documenttype;
use Ramsey\Uuid\Uuid;
class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $data = [
            'Skema Pembayaran',
            'FC KTP Pemilik',
            'FC NPWP Pemilik',
            'PBB',
            'Salinan Draft Sewa',
            'Kontrak Perjanjian',
            'Quotation / Penawaran',
            'Kwitansi/Nota/Bukti Bayar',
        ];
        foreach ($data as $item) {
    Documenttype::create([
        'id' => Uuid::uuid7()->toString(),
        'document_type_name' => $item
    ]);
}
    }
}