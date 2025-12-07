<?php

namespace App\Mate;

use Mcp\Capability\Attribute\McpTool;

class TestTool
{
    #[McpTool(
        name: 'test_tool',
        description: 'Simple test tool'
    )]
    public function execute(): array
    {
        return ['result' => 'Hello from test tool!'];
    }
}
