<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class NoteBoard extends Component
{
    public $section1 = [];
    public $section2 = [];

    public $showModal = false;
    public $editingNote = null;

    public $title = '';
    public $content = '';
    public $section = 1;

    public $deleteId = null;

    public function mount()
    {
        $this->loadNotes();
    }

    public function loadNotes()
    {
        $this->section1 = Note::where('section', 1)->orderBy('order')->get()->toArray();
        $this->section2 = Note::where('section', 2)->orderBy('order')->get()->toArray();
    }

    public function updateOrder($section, $ids)
    {
       
        foreach ($ids as $index => $id) {
            Note::where('id', $id)->update([
                'order' => $index,
                'section' => $section,
            ]);
        }

        $this->loadNotes();
    }

    public function createNote($section)
    {
        $this->reset(['title', 'content', 'editingNote']);
        $this->section = $section;
        $this->showModal = true;
    }

    public function editNote($id)
    {
        $note = Note::findOrFail($id);
        $this->editingNote = $note;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->section = $note->section;
        $this->showModal = true;
    }

    public function saveNote()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        if ($this->editingNote) {
            $this->editingNote->update([
                'title' => $this->title,
                'content' => $this->content,
                'section' => $this->section,
            ]);
        } else {
            $maxOrder = Note::where('section', $this->section)->max('order') ?? 0;

            Note::create([
                'title' => $this->title,
                'content' => $this->content,
                'section' => $this->section,
                'order' => $maxOrder + 1,
            ]);
        }

        $this->showModal = false;
        $this->loadNotes();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteNote()
    {
        Note::find($this->deleteId)?->delete();
        $this->deleteId = null;
        $this->loadNotes();
    }

    public function render()
    {
        return view('livewire.note-board');
    }
}
