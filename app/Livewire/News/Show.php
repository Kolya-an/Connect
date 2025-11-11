<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\News;

class Show extends Component
{
    public $news;

    public function mount($slug)
    {
        $this->news = News::with('categories')->where('slug', $slug)->firstOrFail();
        $this->news->increment('views');
    }

    public function render()
    {
        return view('livewire.news.show')
            ->layout('layouts.view')
            ->layoutData([
                'pageTitle' => $this->news->meta_title,
            ])
            ->title($this->news->meta_title ?? $this->news->title);
    }
}
