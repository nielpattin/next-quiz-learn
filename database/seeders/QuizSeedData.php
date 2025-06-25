<?php
return [
    [
        'title' => 'Basic Math',
        'description' => 'Test your basic math skills.',
        'questions' => [
            [
                'question' => 'What is 2 + 2?',
                'options' => [
                    ['option_text' => '3', 'is_correct' => false],
                    ['option_text' => '4', 'is_correct' => true],
                    ['option_text' => '5', 'is_correct' => false],
                    ['option_text' => '22', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'What is 5 multiplied by 3?',
                'options' => [
                    ['option_text' => '8', 'is_correct' => false],
                    ['option_text' => '10', 'is_correct' => false],
                    ['option_text' => '15', 'is_correct' => true],
                    ['option_text' => '25', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'If you have 10 apples and eat 3, how many do you have left?',
                'options' => [
                    ['option_text' => '6', 'is_correct' => false],
                    ['option_text' => '7', 'is_correct' => true],
                    ['option_text' => '8', 'is_correct' => false],
                    ['option_text' => '13', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'General Knowledge',
        'description' => 'Test your general knowledge.',
        'questions' => [
            [
                'question' => 'What is the capital of France?',
                'options' => [
                    ['option_text' => 'Berlin', 'is_correct' => false],
                    ['option_text' => 'Madrid', 'is_correct' => false],
                    ['option_text' => 'Paris', 'is_correct' => true],
                    ['option_text' => 'Rome', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Which planet is known as the Red Planet?',
                'options' => [
                    ['option_text' => 'Earth', 'is_correct' => false],
                    ['option_text' => 'Mars', 'is_correct' => true],
                    ['option_text' => 'Jupiter', 'is_correct' => false],
                    ['option_text' => 'Venus', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Who painted the Mona Lisa?',
                'options' => [
                    ['option_text' => 'Vincent van Gogh', 'is_correct' => false],
                    ['option_text' => 'Pablo Picasso', 'is_correct' => false],
                    ['option_text' => 'Leonardo da Vinci', 'is_correct' => true],
                    ['option_text' => 'Claude Monet', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Science Basics',
        'description' => 'Fundamental science questions.',
        'questions' => [
            [
                'question' => 'What is the chemical symbol for water?',
                'options' => [
                    ['option_text' => 'O2', 'is_correct' => false],
                    ['option_text' => 'H2O', 'is_correct' => true],
                    ['option_text' => 'CO2', 'is_correct' => false],
                    ['option_text' => 'NaCl', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'What force pulls objects towards the center of the Earth?',
                'options' => [
                    ['option_text' => 'Magnetism', 'is_correct' => false],
                    ['option_text' => 'Friction', 'is_correct' => false],
                    ['option_text' => 'Gravity', 'is_correct' => true],
                    ['option_text' => 'Tension', 'is_correct' => false],
                ],
            ],
        ],
    ],
];