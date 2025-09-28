<?php

namespace App\Livewire;

use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ApiDemo extends Component
{
    public $questions;
    public $question_text = '';
    public $options_input = ['', '', '', ''];
    public $correct_option = '';
    public $solution = '';
    public $question_text_hi = '';
    public $options_hi = ['', '', '', ''];
    public $questionId;
    public $isEditing = false;

    protected $rules = [
        'question_text' => 'required|min:5',
        'options_input' => 'required|array|size:4',
        'options_input.*' => 'required|string|min:1',
        'correct_option' => 'required|in_array:options_input.*',
        'solution' => 'nullable|string',
    ];

    protected $listeners = ['optionsUpdated' => 'updateOptions'];

    public function mount()
    {
        $this->questions = Question::orderBy('created_at', 'desc')->get();
        $this->options_input = ['', '', '', ''];
    }

    public function createQuestion()
    {
        $this->validate();

        $options = array_filter(array_map('trim', $this->options_input));
        if (count($options) !== 4) {
            $this->addError('options_input', 'Exactly four options are required.');
            return;
        }

        $questionHi = $this->translateText($this->question_text);
        $optionsHi = array_map([$this, 'translateText'], $options);

        // Store the raw LaTeX content directly
        Question::create([
            'question_text' => $this->question_text, // Store with LaTeX intact
            'options' => json_encode($options), // Store with LaTeX intact
            'correct_option' => $this->correct_option,
            'solution' => $this->solution, // Store with LaTeX intact
            'translations' => [
                'hi' => [
                    'question_text' => $questionHi,
                    'options' => $optionsHi,
                ],
            ],
        ]);

        $this->resetInput();
        $this->loadQuestions();
        session()->flash('message', 'Question created successfully.');
    }

    public function editQuestion($id)
    {
        $question = Question::findOrFail($id);
        $this->questionId = $id;
        $this->question_text = $question->question_text; // Get raw LaTeX
        $this->options_input = json_decode($question->options, true) ?? ['', '', '', ''];
        $this->correct_option = $question->correct_option;
        $this->solution = $question->solution; // Get raw LaTeX
        $this->question_text_hi = $question->translations['hi']['question_text'] ?? '';
        $this->options_hi = $question->translations['hi']['options'] ?? ['', '', '', ''];
        $this->isEditing = true;
    }

    public function updateQuestion()
    {
        $this->validate();

        $options = array_filter(array_map('trim', $this->options_input));
        if (count($options) !== 4) {
            $this->addError('options_input', 'Exactly four options are required.');
            return;
        }

        if ($this->questionId) {
            $question = Question::find($this->questionId);

            $questionHi = $this->translateText($this->question_text);
            $optionsHi = array_map([$this, 'translateText'], $options);

            // Update with raw LaTeX content
            $question->update([
                'question_text' => $this->question_text, // Keep LaTeX intact
                'options' => json_encode($options), // Keep LaTeX intact
                'correct_option' => $this->correct_option,
                'solution' => $this->solution, // Keep LaTeX intact
                'translations' => [
                    'hi' => [
                        'question_text' => $questionHi,
                        'options' => $optionsHi,
                    ],
                ],
            ]);

            $this->resetInput();
            $this->loadQuestions();
            session()->flash('message', 'Question updated successfully.');
        }
    }

    public function deleteQuestion($id)
    {
        Question::find($id)->delete();
        $this->loadQuestions();
        session()->flash('message', 'Question deleted successfully.');
    }

    private function translateText($text)
    {
        if (!$text) {
            return '';
        }

        try {
            $response = Http::withoutVerifying()->post("https://api.ptpinstitute.com/api/translator/", [
                "text" => $text,
                "source" => "en",
                "dest" => "hi"
            ]);

            return $response->json('translated') ?? $text;
        } catch (\Exception $e) {
            session()->flash('error', 'Translation failed: ' . $e->getMessage());
            return $text;
        }
    }

    public function updateOptions($options)
    {
        $this->options_input = $options;
        $this->options_hi = array_map([$this, 'translateText'], $options);
    }

    public function resetInput()
    {
        $this->question_text = '';
        $this->options_input = ['', '', '', ''];
        $this->correct_option = '';
        $this->solution = '';
        $this->question_text_hi = '';
        $this->options_hi = ['', '', '', ''];
        $this->questionId = null;
        $this->isEditing = false;
    }

    public function loadQuestions()
    {
        $this->questions = Question::orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.api-demo');
    }
}