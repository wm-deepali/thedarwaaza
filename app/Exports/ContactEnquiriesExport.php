<?php

namespace App\Exports;

use App\Models\ContactEnquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContactEnquiriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private int $index = 0;

    public function __construct(private ?string $type = null)
    {
    }

    public function collection()
    {
        return ContactEnquiry::with('product')
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['#', 'Name', 'Email', 'Phone', 'Product', 'Enquiry Type', 'Message', 'Status', 'Date'];
    }

    public function map($item): array
    {
        return [
            ++$this->index,
            $item->name,
            $item->email,
            $item->phone,
            $item->product ? ($item->product->name ?: 'Product #' . $item->product->id) : '—',
            $item->type ?: '—',
            $item->message,
            $item->is_read ? 'Read' : 'New',
            $item->created_at->format('d M Y h:i A'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF303D89']],
            ],
        ];
    }
}