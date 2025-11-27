<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\News;
use App\Models\Category;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedCategory = null;
    public $categorySlug;
    public $category;
    public $sortField = 'views'; // по умолчанию популярность
    public $sortDirection = 'desc';
    public $showSortDropdown = false;
    public function mount($categorySlug = null)
    {
        if ($categorySlug) {
            $this->category = Category::where('slug', $categorySlug)->firstOrFail();
        }
    }
    public function setCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage(); // сброс пагинации при фильтрации
    }
    public function setSort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = $field === 'title' ? 'asc' : 'desc';
        }
        $this->showSortDropdown = false;
    }
    public function toggleSortDropdown()
    {
        $this->showSortDropdown = !$this->showSortDropdown;
    }

    // НОВИЙ МЕТОД: Закриття (використовується для @click.away)
    public function closeSortDropdown()
    {
        $this->showSortDropdown = false;
    }
    public function render()
    {
        $query = News::with('categories')->orderBy($this->sortField, $this->sortDirection);

        if ($this->selectedCategory) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->selectedCategory);
            });
        }

        $news = $query->paginate(12);
        $categories = Category::all();

        return view('livewire.news.index', compact('news', 'categories'))
            ->layout('layouts.view');
    }
}

