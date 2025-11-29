# debug-mcp-symfony-example

**⚠️ PROTOTYPE - Example Symfony 8.0 project with MCP server integration**

## What is this?

Demonstrates a working MCP (Model Context Protocol) server for PHP development with:
- **3 Tools**: `clock`, `php_config`, `test_tool`
- **1 Prompt**: `symfony_command`
- **2 Static Resources**: `test://info/about`, `test://info/help`
- **2 Resource Templates**: `php://docs/{topic}`, `symfony://docs/{topic}`

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

## Testing Questions

### Tools
Ask Claude Code to test tools:
- **"What time is it in Tokyo?"** → `clock` tool with timezone
- **"What PHP extensions are loaded?"** → `php_config` tool
- **"Show me the PHP configuration"** → `php_config` tool

### Resources
Ask Claude Code to test resources:
- **"Show me the test information"** → Static resource
- **"Show me PHP best practices"** → Resource template: `php://docs/best-practices`
- **"Show me Symfony console documentation"** → Resource template: `symfony://docs/console-commands`

### Prompts
Ask Claude Code to test prompts:
- **"Generate a Symfony command to import users from CSV"** → `symfony_command` prompt
- **"Create a command called app:process-orders"** → `symfony_command` prompt

## Use Cases

- Get timestamps for logging/debugging
- Check PHP configuration without leaving editor
- Access PHP and Symfony documentation while coding
- Generate Symfony console commands with best practices
- Prototype custom MCP tools in `mcp/` directory

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
