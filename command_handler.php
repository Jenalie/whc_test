<?php

// Defined a class for handling commands
abstract class CommandHandler {
    abstract public function execute(array $args);
}

class AddCommandHandler extends CommandHandler {
    public function execute(array $args) {
        if (count($args) < 2) {
            return "Not enough arguments. At least two numbers are required.";
        }
        $sum = 0;
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
            $sum += (int)$arg;
        }
        return $sum;
    }
}

class SortAscCommandHandler extends CommandHandler {
    public function execute(array $args) {
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
        }
        sort($args);
        return implode(' ', $args);
    }
}

class RepoDescCommandHandler extends CommandHandler {
    public function execute(array $args) {
        if (count($args) != 2) {
            return "Invalid arguments. Please provide the owner and repo name.";
        }

        $owner = $args[0];
        $repo = $args[1];
        $url = "https://api.github.com/repos/$owner/$repo";
        $options = [
            "http" => [
                "header" => "User-Agent: PHP"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === FALSE) {
            return "Error fetching repository data.";
        }

        $data = json_decode($response, true);
        if (isset($data['description'])) {
            return $data['description'];
        } else {
            return "No description available for this repository.";
        }
    }
}

// Added more command handlers such as subtract, multiply, divide and sort-desc 
class SubtractCommandHandler extends CommandHandler {
    public function execute(array $args) {
        if (count($args) < 2) {
            return "Not enough arguments. At least two numbers are required.";
        }
        $result = array_shift($args); // Get the first argument
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
            $result -= (int)$arg;
        }
        return $result;
    }
}

class DivideCommandHandler extends CommandHandler {
    public function execute(array $args) {
        if (count($args) < 2) {
            return "Please provide at least two numbers.";
        }
        $result = array_shift($args);
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
            if ($arg == 0) {
                return "Cannot divide by zero.";
            }
            $result /= (int)$arg;
        }
        return $result;
    }
}

class MultiplyCommandHandler extends CommandHandler {
    public function execute(array $args) {
        if (count($args) < 2) {
            return "Please provide at least two numbers.";
        }
        $result = array_shift($args);
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
            $result *= (int)$arg;
        }
        return $result;
    }
}

class SortDescCommandHandler extends CommandHandler {
    public function execute(array $args) {
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return "Invalid argument: '$arg'. All arguments must be numbers.";
            }
        }
        rsort($args);  // Sort in descending order
        return implode(' ', $args);
    }
}

// Command handler registry
$commandHandlers = [
    'add'       => new AddCommandHandler(),
    'sort-asc'  => new SortAscCommandHandler(),
    'repo-desc' => new RepoDescCommandHandler(),
    'subtract'  => new SubtractCommandHandler(),
    'divide'    => new DivideCommandHandler(),
    'multiply'  => new MultiplyCommandHandler(),
    'sort-desc' => new SortDescCommandHandler()
];

// Read the incoming request
$requestData = json_decode(file_get_contents('php://input'), true);
$commandName = $requestData['commandName'];
$args = $requestData['args'] ?? [];

// Validate the command
if (isset($commandHandlers[$commandName])) {
    $handler = $commandHandlers[$commandName];
    $result = $handler->execute($args);
    echo json_encode(['result' => $result]);
} else {
    echo json_encode(['result' => 'Unknown command.']);
}
?>