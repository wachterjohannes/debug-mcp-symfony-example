# debug-mcp-symfony-example

**⚠️ PROTOTYPE - Example Symfony 8.0 project with MCP server integration**

## What is this?

Demonstrates a working MCP (Model Context Protocol) server for PHP development with:
- **2 Tools**: `clock` (time/timezone), `php_config` (PHP inspection)
- **1 Prompt**: `symfony_command` (generate Symfony commands)

## Quick Start

```bash
git clone https://github.com/wachterjohannes/debug-mcp-symfony-example.git
cd debug-mcp-symfony-example
composer install
```

## Usage

### Claude Code (Recommended)

```bash
cd /path/to/debug-mcp-symfony-example
claude mcp add debug-mcp-symfony $(pwd)/vendor/bin/debug-mcp --scope local
claude mcp list  # Verify: debug-mcp-symfony - ✓ Connected
```

Now use tools via natural language:
- "What time is it in Tokyo?"
- "What PHP extensions are loaded?"
- "Generate a Symfony command to import users"

### Claude Desktop

Edit `~/Library/Application Support/Claude/claude_desktop_config.json`:

```json
{
  "mcpServers": {
    "debug-mcp-symfony": {
      "command": "/absolute/path/to/debug-mcp-symfony-example/vendor/bin/debug-mcp"
    }
  }
}
```

Restart Claude Desktop.

## Add Your Own Tools

Create `mcp/MyTool.php`:

```php
<?php
namespace App\Mcp;

use Mcp\Capability\Attribute\McpTool;

class MyTool {
    #[McpTool(name: 'my_tool', description: 'Does something')]
    public function execute(string $input): array {
        return ['result' => $input];
    }
}
```

Auto-discovered on next request.

## Ecosystem

Part of debug-mcp prototype:
- [debug-mcp](https://github.com/wachterjohannes/debug-mcp) - Core server
- [debug-mcp-tools](https://github.com/wachterjohannes/debug-mcp-tools) - Tools
- [debug-mcp-prompts](https://github.com/wachterjohannes/debug-mcp-prompts) - Prompts
- [debug-mcp-resources](https://github.com/wachterjohannes/debug-mcp-resources) - Resources

## Requirements

PHP 8.4+, Composer

## License

MIT
