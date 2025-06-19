<div class="container mx-auto p-4 max-w-3xl bg-blue-50 rounded-lg shadow-lg">
        @if(!$isCompleted)
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <button class="text-indigo-500 hover:text-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h1 class="text-2xl font-bold text-indigo-800">{{ $quiz->title }}</h1>
            <div class="text-lg font-semibold text-indigo-600">{{ gmdate('i:s', $timeRemaining) }}</div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <p class="text-sm text-indigo-600 mb-2">Câu {{ $this->currentQuestionIndex + 1 }}/{{ $this->questions->count() }}</p>
            <div class="w-full bg-indigo-200 rounded-full h-2.5">
                <div class="bg-teal-400 h-2.5 rounded-full" style="width: {{ $this->progress }}%"></div>
            </div>
        </div>

        <!-- Question Area -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-xl font-semibold text-indigo-800 mb-4">{{ $this->currentQuestion->question }}</h2>

            @if ($this->currentQuestion->image_url)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $this->currentQuestion->image_url) }}" alt="Question Image" class="max-w-full h-auto rounded-md">
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4">
                @foreach ($this->currentQuestion->options as $optionKey => $optionText)
                    <button
                        wire:click="selectAnswer({{ $this->currentQuestion->id }}, '{{ $optionKey }}')"
                        {{ $isAnswerChecked ? 'disabled' : '' }}
                        class="block w-full text-left p-4 border rounded-lg transition-all duration-200
                                @if ($isAnswerChecked)
                                    @if ($feedback['correct'] && $selectedAnswer === $optionKey)
                                        bg-green-300 border-green-400 ring-2 ring-green-400
                                    @elseif (!$feedback['correct'] && $selectedAnswer === $optionKey)
                                        bg-red-300 border-red-400 ring-2 ring-red-400
                                    @elseif (!$feedback['correct'] && $optionKey === $feedback['correct_option'])
                                        bg-green-100 border-green-400 ring-2 ring-green-400
                                    @else
                                        border-indigo-300
                                    @endif
                                @else
                                    {{ $selectedAnswer === $optionKey ? 'border-teal-500 ring-2 ring-teal-500 bg-teal-100' : 'border-indigo-300 bg-indigo-50 hover:border-indigo-400 hover:bg-indigo-100' }}
                                @endif
                                focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                    >
                        <span class="font-medium text-indigo-800">{{ $optionText }}</span>
                    </button>
                @endforeach
            </div>
            @if ($isAnswerChecked)
                <div class="mt-4 text-center text-lg font-semibold">
                    @if ($feedback['correct'])
                        <p class="text-green-600">Chính xác!</p>
                    @else
                        <p class="text-red-600">Chưa đúng!</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Action Button -->
        <div class="flex justify-center">
            <button
                wire:click="{{ $isAnswerChecked ? ($this->currentQuestionIndex + 1 === $this->questions->count() ? 'submitQuiz' : 'nextQuestion') : 'checkAnswer' }}"
                {{ is_null($selectedAnswer) && !$isAnswerChecked ? 'disabled' : '' }}
                class="px-8 py-3 bg-teal-500 text-white font-semibold rounded-lg shadow-md
                       hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2
                       disabled:opacity-50 disabled:cursor-not-allowed"
            >
                @if ($isAnswerChecked)
                    {{ $this->currentQuestionIndex + 1 === $this->questions->count() ? 'Nộp bài' : 'Tiếp theo' }}
                @else
                    Kiểm tra
                @endif
            </button>
        </div>
        @else
            <!-- Placeholder for completed state, as per instructions -->
            <div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md mx-auto">
                <h2 class="text-3xl font-bold text-indigo-800 mb-6">Kết quả</h2>

                <div class="mb-6">
                    <p class="text-xl text-indigo-700 mb-2">Điểm của bạn: <span class="font-bold text-teal-500">{{ $score }}%</span></p>
                    <p class="text-md text-indigo-600">Trả lời đúng: <span class="font-semibold text-green-500">{{ $correctAnswersCount }}</span></p>
                    <p class="text-md text-indigo-600">Trả lời sai: <span class="font-semibold text-red-500">{{ $incorrectAnswersCount }}</span></p>
                </div>

                <div class="flex flex-col space-y-4">
                    <button
                        wire:click="restartQuiz"
                        class="w-full bg-teal-500 text-white py-3 rounded-lg font-semibold hover:bg-teal-600 transition duration-200"
                    >
                        Chơi lại
                    </button>
                    <a
                        href="{{ route('dashboard') }}"
                        class="w-full bg-indigo-200 text-indigo-800 py-3 rounded-lg font-semibold hover:bg-indigo-300 transition duration-200"
                    >
                        Thoát
                    </a>
                </div>
            </div>
        @endif
    </div>