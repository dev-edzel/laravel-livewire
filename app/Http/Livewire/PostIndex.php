<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostIndex extends Component
{   
    use WithFileUploads, WithPagination;
    public $showingPostModal = false;

    public $title;
    public $newImage;
    public $body;
    public $oldImage;
    public $isEditMode = false;
    public $post;
    public $search;
    public $searchTerm;


    public function showPostModal()
    {
        $this->reset();
        $this->showingPostModal = true;
        $this->search = '';
        
    }

    public function storePost()
    {   
        $this->validate([
            'newImage' => 'image|max:1024', // 1MB Max
            'title' => 'required',
            'body' => 'required'
        ]);

        $image = $this->newImage->store('public/posts');

        Post::create([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body,
        ]);
        $this->reset();
    }

    public function showEditPostModal($id)
    {
        $this->post = Post::findOrFail($id);
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->oldImage = $this->post->image;
        $this->isEditMode = true;
        $this->showingPostModal = true;
        $this->search = '';
    }

    public function updatePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $image = $this->post->image; 
        if($this->newImage){
            $image = $this->newImage->store('public/posts');
        }       

        $this->post->update([
            'title' => $this->title,
            'image' => $image,
            'body' => $this->body
        ]);
        $this->reset();
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete($post->image);
        $post->delete();
        $this->reset();
    }

    public function render()
    {
        $posts = Post::paginate(5);

        return view('livewire.post-index', compact('posts'));
    }
    
    public function resetSearchTerm()
    {
        $this->searchTerm = '';
    }

}
