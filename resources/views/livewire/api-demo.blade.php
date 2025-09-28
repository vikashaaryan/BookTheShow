<div>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Question Management System</h1>

        @if (session()->has('message'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg mb-6 shadow-sm animate-fade-in">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg mb-6 shadow-sm animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <!-- KaTeX CSS (Add this in your main layout or here) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">

        <div class="mb-8 p-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">{{ $isEditing ? 'Edit Question' : 'Add New Question' }}</h2>

            <form wire:submit.prevent="{{ $isEditing ? 'updateQuestion' : 'createQuestion' }}" class="space-y-6">
                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-2" for="question-input">
                        Question (English) - Supports LaTeX: Use $E = mc^2$ for inline or $$E = mc^2$$ for display
                    </label>
                    <textarea wire:model.debounce.500ms="question_text" id="question-input" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              placeholder="Enter question in English. Use $E = mc^2$ for math equations" rows="4"></textarea>
                    @error('question_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    <!-- Live Preview -->
                    <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                        <label class="block text-gray-600 font-medium mb-2">Live Preview:</label>
                        <div wire:ignore id="question-preview" class="min-h-20 p-3 border rounded bg-white"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-2">Options (Enter exactly 4 options - Supports LaTeX)</label>
                    @for ($i = 0; $i < 4; $i++)
                        <div class="mb-4">
                            <div class="flex gap-4 mb-2">
                                <div class="flex-1">
                                    <input type="text" wire:model.debounce.500ms="options_input.{{ $i }}" 
                                           id="option-input-{{ $i }}" 
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                                           placeholder="Option {{ $i + 1 }} (English) - Use $x^2$ for math">
                                </div>
                                <div class="flex-1">
                                    <input type="text" value="{{ $options_hi[$i] ?? '' }}" 
                                           id="option-hi-{{ $i }}" 
                                           class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly 
                                           placeholder="Option {{ $i + 1 }} (Hindi)">
                                </div>
                            </div>
                            <!-- Option Preview -->
                            <div wire:ignore id="option-preview-{{ $i }}" class="ml-4 p-2 bg-gray-50 rounded text-sm min-h-8"></div>
                            @error("options_input.{$i}") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endfor
                    @error('options_input') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-2" for="correct-option">Correct Option</label>
                    <select wire:model="correct_option" id="correct-option" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select correct option</option>
                        @if (is_array($options_input) && !empty($options_input))
                            @foreach ($options_input as $index => $option)
                                @if (!empty($option))
                                    <option value="{{ $option }}">Option {{ $index + 1 }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @error('correct_option') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600 font-medium mb-2" for="solution">
                        Solution (Optional - Supports LaTeX)
                    </label>
                    <textarea wire:model.debounce.500ms="solution" id="solution" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                              placeholder="Enter solution (optional) - Use $\sqrt{x}$ for math" rows="4"></textarea>
                    
                    <!-- Solution Preview -->
                    <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                        <label class="block text-gray-600 font-medium mb-2">Solution Preview:</label>
                        <div wire:ignore id="solution-preview" class="min-h-20 p-3 border rounded bg-white"></div>
                    </div>
                    @error('solution') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        {{ $isEditing ? 'Update Question' : 'Add Question' }}
                    </button>
                    @if($isEditing)
                        <button type="button" wire:click="resetInput" 
                                class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700 p-6 border-b">Questions (with KaTeX rendering)</h2>

            @if($questions->count())
                <ul>
                    @foreach($questions as $question)
                        <li class="p-6 border-b last:border-b-0 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex flex-col gap-4 flex-1">
                                    <!-- English Question with KaTeX -->
                                    <div>
                                        <h3 class="font-medium text-gray-800 mb-2">Question:</h3>
                                        <div wire:ignore class="question-content text-gray-700 p-2 bg-blue-50 rounded">
                                            {!! $question->question_text !!}
                                        </div>
                                        
                                        <h4 class="font-medium text-gray-800 mt-3 mb-2">Options:</h4>
                                        @php
                                            $options = json_decode($question->options, true) ?? [];
                                        @endphp
                                        <ol class="list-decimal list-inside space-y-1">
                                            @foreach($options as $index => $option)
                                                <li wire:ignore class="option-content p-1 {{ $option === $question->correct_option ? 'bg-green-50 text-green-700 font-medium rounded' : '' }}">
                                                    {{ $option }}
                                                    @if($option === $question->correct_option)
                                                        <span class="text-green-600 ml-2">✓ Correct</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                        
                                        @if($question->solution)
                                            <h4 class="font-medium text-gray-800 mt-3 mb-2">Solution:</h4>
                                            <div wire:ignore class="solution-content text-gray-600 p-2 bg-yellow-50 rounded">
                                                {!! $question->solution !!}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Hindi Translation -->
                                    @if($question->translations['hi']['question_text'] ?? false)
                                        <div class="border-t pt-4">
                                            <h3 class="font-medium text-green-700 mb-2">हिंदी अनुवाद:</h3>
                                            <p class="text-green-800">{{ $question->translations['hi']['question_text'] }}</p>
                                            <p class="text-sm text-gray-600 mt-2">विकल्प: {{ implode(', ', $question->translations['hi']['options'] ?? []) }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-4 ml-4">
                                    <button wire:click="editQuestion({{ $question->id }})" 
                                            class="text-blue-600 hover:underline px-3 py-1 border border-blue-600 rounded">
                                        Edit
                                    </button>
                                    <button wire:click="deleteQuestion({{ $question->id }})" 
                                            class="text-red-600 hover:underline px-3 py-1 border border-red-600 rounded" 
                                            onclick="return confirm('Are you sure you want to delete this question?')">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 flex justify-between">
                                <span>Created: {{ $question->created_at->format('M d, Y H:i') }}</span>
                                @if($question->translations['hi']['question_text'] ?? false)
                                    <span>Hindi Available</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="p-6 text-gray-600">No questions found. Add a new question above.</p>
            @endif
        </div>
    </div>

    <!-- KaTeX JS -->
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* KaTeX styling */
        .katex { font-size: 1.1em; }
        .question-content .katex { font-size: 1.2em; }
        .solution-content .katex { font-size: 1.1em; }
    </style>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize KaTeX
    function renderKaTeX() {
        // Render question preview
        renderTextWithKaTeX('question-input', 'question-preview');
        
        // Render option previews
        for (let i = 0; i < 4; i++) {
            renderTextWithKaTeX(`option-input-${i}`, `option-preview-${i}`);
        }
        
        // Render solution preview
        renderTextWithKaTeX('solution', 'solution-preview');
        
        // Render existing questions
        renderExistingContent();
    }

    function renderTextWithKaTeX(sourceId, targetId) {
        const source = document.getElementById(sourceId);
        const target = document.getElementById(targetId);
        
        if (source && target) {
            const text = source.value;
            target.innerHTML = ''; // Clear previous content
            
            if (text.trim()) {
                try {
                    // Split text by LaTeX delimiters and render accordingly
                    renderMixedContent(text, target);
                } catch (error) {
                    target.innerHTML = `<span class="text-red-500">Error rendering: ${error.message}</span>`;
                }
            }
        }
    }

    function renderMixedContent(text, container) {
        // Simple parser for $...$ and $$...$$ delimiters
        const parts = text.split(/(\$\$.*?\$\$|\$.*?\$)/g);
        
        parts.forEach(part => {
            if (!part) return;
            
            if (part.startsWith('$$') && part.endsWith('$$')) {
                // Display math
                const math = part.slice(2, -2);
                const div = document.createElement('div');
                div.className = 'text-center my-2';
                katex.render(math, div, { displayMode: true, throwOnError: false });
                container.appendChild(div);
            } else if (part.startsWith('$') && part.endsWith('$')) {
                // Inline math
                const math = part.slice(1, -1);
                const span = document.createElement('span');
                katex.render(math, span, { throwOnError: false });
                container.appendChild(span);
            } else {
                // Regular text
                const span = document.createElement('span');
                span.textContent = part;
                container.appendChild(span);
            }
        });
    }

    function renderExistingContent() {
        // Render existing questions
        document.querySelectorAll('.question-content').forEach(container => {
            const text = container.textContent || container.innerText;
            container.innerHTML = '';
            renderMixedContent(text, container);
        });

        // Render existing options
        document.querySelectorAll('.option-content').forEach(container => {
            const text = container.textContent || container.innerText;
            // Remove the "✓ Correct" text before rendering
            const cleanText = text.replace('✓ Correct', '').trim();
            container.innerHTML = '';
            renderMixedContent(cleanText, container);
            
            // Re-add correct indicator if it was present
            if (text.includes('✓ Correct')) {
                const correctSpan = document.createElement('span');
                correctSpan.className = 'text-green-600 ml-2';
                correctSpan.textContent = '✓ Correct';
                container.appendChild(correctSpan);
            }
        });

        // Render existing solutions
        document.querySelectorAll('.solution-content').forEach(container => {
            const text = container.textContent || container.innerText;
            container.innerHTML = '';
            renderMixedContent(text, container);
        });
    }

    // Initial render
    renderKaTeX();

    // Live preview on input
    const inputs = ['question-input', 'solution', 'option-input-0', 'option-input-1', 'option-input-2', 'option-input-3'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', function() {
                if (inputId === 'question-input') {
                    renderTextWithKaTeX('question-input', 'question-preview');
                } else if (inputId.startsWith('option-input-')) {
                    const index = inputId.split('-')[2];
                    renderTextWithKaTeX(`option-input-${index}`, `option-preview-${index}`);
                } else if (inputId === 'solution') {
                    renderTextWithKaTeX('solution', 'solution-preview');
                }
            });
        }
    });

    // Re-render when Livewire updates
    Livewire.hook('message.processed', () => {
        setTimeout(renderKaTeX, 100);
    });

    // Your existing translation code (keep this)
    const questionInput = document.getElementById('question-input');
    const questionHi = document.getElementById('question-hi');
    const optionInputs = [
        document.getElementById('option-input-0'),
        document.getElementById('option-input-1'),
        document.getElementById('option-input-2'),
        document.getElementById('option-input-3'),
    ];
    const optionHiInputs = [
        document.getElementById('option-hi-0'),
        document.getElementById('option-hi-1'),
        document.getElementById('option-hi-2'),
        document.getElementById('option-hi-3'),
    ];

    async function translateText(text, targetElement) {
        if (!text.trim()) {
            if (targetElement) targetElement.value = '';
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
            if (targetElement) targetElement.value = data.translated || text;
        } catch (error) {
            console.error('Translation error:', error);
            if (targetElement) targetElement.value = 'Translation failed';
        }
    }

    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    if (questionInput && questionHi) {
        questionInput.addEventListener('input', debounce(() => {
            translateText(questionInput.value, questionHi);
        }, 500));
    }

    optionInputs.forEach((input, index) => {
        if (input && optionHiInputs[index]) {
            input.addEventListener('input', debounce(() => {
                translateText(input.value, optionHiInputs[index]);
            }, 500));
        }
    });
});
</script>