<?php
return [
    [
        'title' => 'Basic Math',
        'description' => 'Test your basic math skills.',
        'is_pro' => true,
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
        'is_pro' => true,
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
    [
        'title' => 'World Capitals',
        'description' => 'Quiz about world capitals.',
        'questions' => [
            [
                'question' => 'What is the capital of Japan?',
                'options' => [
                    ['option_text' => 'Seoul', 'is_correct' => false],
                    ['option_text' => 'Tokyo', 'is_correct' => true],
                    ['option_text' => 'Beijing', 'is_correct' => false],
                    ['option_text' => 'Bangkok', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'What is the capital of Australia?',
                'options' => [
                    ['option_text' => 'Sydney', 'is_correct' => false],
                    ['option_text' => 'Melbourne', 'is_correct' => false],
                    ['option_text' => 'Canberra', 'is_correct' => true],
                    ['option_text' => 'Perth', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Technology Trivia',
        'description' => 'Test your knowledge of technology.',
        'questions' => [
            [
                'question' => 'Who is known as the father of computers?',
                'options' => [
                    ['option_text' => 'Alan Turing', 'is_correct' => false],
                    ['option_text' => 'Charles Babbage', 'is_correct' => true],
                    ['option_text' => 'Bill Gates', 'is_correct' => false],
                    ['option_text' => 'Steve Jobs', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'What does CPU stand for?',
                'options' => [
                    ['option_text' => 'Central Processing Unit', 'is_correct' => true],
                    ['option_text' => 'Computer Personal Unit', 'is_correct' => false],
                    ['option_text' => 'Central Print Unit', 'is_correct' => false],
                    ['option_text' => 'Control Processing Unit', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Literature',
        'description' => 'Questions about famous books and authors.',
        'questions' => [
            [
                'question' => 'Who wrote "Romeo and Juliet"?',
                'options' => [
                    ['option_text' => 'William Shakespeare', 'is_correct' => true],
                    ['option_text' => 'Jane Austen', 'is_correct' => false],
                    ['option_text' => 'Mark Twain', 'is_correct' => false],
                    ['option_text' => 'Charles Dickens', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'What is the name of the wizarding school in Harry Potter?',
                'options' => [
                    ['option_text' => 'Hogwarts', 'is_correct' => true],
                    ['option_text' => 'Beauxbatons', 'is_correct' => false],
                    ['option_text' => 'Durmstrang', 'is_correct' => false],
                    ['option_text' => 'Ilvermorny', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Sports',
        'description' => 'Test your sports knowledge.',
        'questions' => [
            [
                'question' => 'How many players are there in a soccer team on the field?',
                'options' => [
                    ['option_text' => '9', 'is_correct' => false],
                    ['option_text' => '10', 'is_correct' => false],
                    ['option_text' => '11', 'is_correct' => true],
                    ['option_text' => '12', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Which country hosted the 2016 Summer Olympics?',
                'options' => [
                    ['option_text' => 'China', 'is_correct' => false],
                    ['option_text' => 'Brazil', 'is_correct' => true],
                    ['option_text' => 'UK', 'is_correct' => false],
                    ['option_text' => 'Russia', 'is_correct' => false],
                ],
            ],
        ],
    ],
    [
        'title' => 'Music',
        'description' => 'Quiz about music and musicians.',
        'questions' => [
            [
                'question' => 'Who is known as the "King of Pop"?',
                'options' => [
                    ['option_text' => 'Elvis Presley', 'is_correct' => false],
                    ['option_text' => 'Michael Jackson', 'is_correct' => true],
                    ['option_text' => 'Freddie Mercury', 'is_correct' => false],
                    ['option_text' => 'Prince', 'is_correct' => false],
                ],
            ],
            [
                'question' => 'Which instrument has 88 keys?',
                'options' => [
                    ['option_text' => 'Guitar', 'is_correct' => false],
                    ['option_text' => 'Piano', 'is_correct' => true],
                    ['option_text' => 'Violin', 'is_correct' => false],
                    ['option_text' => 'Drums', 'is_correct' => false],
                ],
            ],
        ],
    ],
];