<div class="max-w-6xl mx-auto">
    <div class="flex justify-end m-2 p-2">
        <x-button wire:click="showPostModal"> Create </x-button>
    </div>
    
    <div class="m-2 p-2">
      <div class="flex items-center justify-between mb-4">
        {{-- <input type="search" wire:model.debounce.500ms="searchTerm" class="w-full rounded-md lg:w-1/3 xl:w-1/4 p-4 text-gray-700 placeholder-gray-400" placeholder="Search...">
        <button wire:click="resetSearchTerm" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">Clear</button> --}}
    </div>
    
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
              <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <div class="m-2 p-2"> 
                  <input type="search" wire:model="searchTerm" class="form-control rounded-md" placeholder="Search...">
                  </div>
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Id</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Title</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Image</th>
                      <th scope="col" class="relative px-6 py-3 w-32">Edit</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                   
                    <tr></tr>
                    @foreach ($posts as $post)
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <img class="w-8 h-8 rounded-full" src="{{ Storage::url($post->image) }}" />
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                          <div class="flex space-x-2 ">
                            <x-button wire:click="showEditPostModal({{ $post->id  }})"> Edit </x-button>
                            <x-button class="bg-red-600 hover:bg-red-400" wire:click="deletePost({{ $post->id  }})"> Delete </x-button>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              
                    <div class="m-2 p-2">{{ $posts->links() }}</div>
              </div>
            </div>
          </div>          
    </div>

    <div>
        <x-dialog-modal wire:model="showingPostModal">
            @if ($isEditMode)
                <x-slot name="title">Update Post</x-slot>
                @else
                <x-slot name="title">Create Post</x-slot> 
            @endif
            <x-slot name="content">
                <div class="space-y-8 divide-y divide-gray-200 mt-10">
                    <form enctype="multipart/form-data">
                      <div class="sm:col-span-6">
                        <label for="title" class="block text-s  m font-medium text-gray-700"> Post Title </label>
                        <div class="mt-1">
                          <input type="text" id="title" wire:model.lazy="title" name="title" 
                          class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal sm:text-sm sm:leading-5" />
                        </div>
                        @error('title') <span class="text-red-400">{{ $message }}</span> @enderror
                      </div>
                      <div class="sm:col-span-6">
                         <label for="title" class="block text-sm font-medium text-gray-700"> Post Image </label>
                         @if ($oldImage)
                         Old Image:
                        <img src="{{ Storage::url($oldImage) }}">
                          @endif
                         @if ($newImage)
                            Photo Preview:
                           <img src="{{ $newImage->temporaryUrl() }}">
                          @endif
                        <div class="mt-1">
                          <input type="file" id="image" wire:model="newImage" name="image" 
                          class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal sm:text-sm sm:leading-5" />
                        </div>
                        @error('newImage') <span class="text-red-400">{{ $message }}</span> @enderror
                      </div>
                      <div class="sm:col-span-6 pt-5">
                        <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                        <div class="mt-1">
                          <textarea id="body" rows="3" wire:model.lazy="body" 
                          class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border py-2 px-3 text-base leading-normal 
                          focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        @error('body') <span class="text-red-400">{{ $message }}</span> @enderror
                      </div>
                    </form>
                  </div>
                  
            </x-slot>
            
            <x-slot name="footer"> 
                @if ($isEditMode)
                    <x-button wire:click="updatePost">Update</x-button>
                    @else
                    <x-button wire:click="storePost">Create</x-button>
                    
                @endif
            </x-slot>
        </x-dialog-modal>
    </div>
</div> 
