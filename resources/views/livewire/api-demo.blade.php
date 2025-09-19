<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Task Manager with Hindi Translation</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 p-4 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-2">{{ $isEditing ? 'Edit Task' : 'Add New Task' }}</h2>

        <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'createTask' }}">
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700">Title (English)</label>
                    <input type="text" wire:model.debounce.500ms="title" id="title-input" class="w-full px-3 py-2 border rounded"
                           placeholder="Enter title in English">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Title (Hindi)</label>
                    <input type="text" id="title-hi" class="w-full px-3 py-2 border rounded bg-gray-100" readonly
                           placeholder="Hindi translation will appear here" value="{{ $title_hi ?? '' }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700">Description (English)</label>
                    <textarea wire:model.debounce.500ms="description" id="description-input" class="w-full px-3 py-2 border rounded"
                              placeholder="Enter description in English"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Description (Hindi)</label>
                    <textarea id="description-hi" class="w-full px-3 py-2 border rounded bg-gray-100" readonly
                              placeholder="Hindi translation will appear here">{{ $description_hi ?? '' }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    {{ $isEditing ? 'Update Task' : 'Add Task' }}
                </button>
                @if($isEditing)
                    <button type="button" wire:click="resetInput" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</button>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded">
        <h2 class="text-xl font-semibold p-4 border-b">Tasks</h2>

        @if($tasks->count())
            <ul>
                @foreach($tasks as $task)
                    <li class="p-4 border-b">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex flex-col gap-2">
                                <div>
                                    <h3 class="{{ $task->completed ? 'line-through text-gray-500' : 'font-medium' }}">
                                        {{ $task->title }}
                                    </h3>
                                    @if($task->description)
                                        <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                    @endif
                                </div>
                                @if($task->translations['hi']['title'] ?? false || $task->translations['hi']['description'] ?? false)
                                    <div class="border-t pt-2">
                                        <h3 class="{{ $task->completed ? 'line-through text-gray-500' : 'font-medium text-green-700' }}">
                                            {{ $task->translations['hi']['title'] ?? '' }}
                                        </h3>
                                        @if($task->translations['hi']['description'] ?? false)
                                            <p class="text-sm text-gray-600">{{ $task->translations['hi']['description'] }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="editTask({{ $task->id }})" class="text-blue-500">Edit</button>
                                <button wire:click="deleteTask({{ $task->id }})" class="text-red-500"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                            </div>
                        </div>
                        <div class="ml-1 text-xs text-gray-500 flex justify-between">
                            <span>English</span>
                            @if($task->translations['hi']['title'] ?? false || $task->translations['hi']['description'] ?? false)
                                <span>Hindi</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="p-4">No tasks found. Add a new task above.</p>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title-input');
        const descriptionInput = document.getElementById('description-input');
        const titleHi = document.getElementById('title-hi');
        const descriptionHi = document.getElementById('description-hi');

        let titleTimeout, descriptionTimeout;

        async function translateText(text, targetElement) {
            if (!text.trim()) {
                targetElement.value = '';
                return;
            }

            try {
                const response = await fetch('https://api.ptpinstitute.com/api/translator/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        text: text,
                        source: 'en',
                        dest: 'hi'
                    })
                });

                if (!response.ok) {
                    throw new Error('API request failed');
                }

                const data = await response.json();
                targetElement.value = data.translated || '';
            } catch (error) {
                console.error('Translation error:', error);
                targetElement.value = 'Translation failed';
            }
        }

        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        titleInput.addEventListener('input', debounce(() => {
            translateText(titleInput.value, titleHi);
        }, 500));

        descriptionInput.addEventListener('input', debounce(() => {
            translateText(descriptionInput.value, descriptionHi);
        }, 500));
    });
</script>
