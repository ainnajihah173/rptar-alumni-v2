<?php

namespace App\Exports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return News::with('users') // Eager load the 'users' relationship
            ->get()
            ->map(function ($news) {
                return [
                    'No.' => $news->id,
                    'Title' => $news->title ?? 'N/A', // Handle null title
                    'Slug' => $news->slug ?? 'N/A', // Handle null slug
                    'Content' => $news->content ?? 'N/A', // Handle null content
                    'Author Name' => $news->users->name ?? 'N/A', // Handle null author
                    'Date Published' => $news->published_date ? date('d-m-Y', strtotime($news->published_date)) : 'N/A', // Handle null date
                    'Status' => $news->is_active ? 'Published' : 'Draft', // Handle status
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No.',
            'Title',
            'Slug',
            'Content',
            'Author Name',
            'Date Published',
            'Status',
        ];
    }
}
