# debug-mcp-symfony-example

**⚠️ EXAMPLE PROJECT - DEMONSTRATES USAGE OF DEBUG-MCP PROTOTYPE**

**This is an example Symfony 8.0 project demonstrating how to integrate and use the debug-mcp MCP server ecosystem. The referenced packages are prototypes for testing and discussion.**

---

## Purpose

This example project demonstrates:
- How to configure local path repositories for debug-mcp packages
- Project structure for a Symfony application using the MCP server
- Configuration files for Claude Desktop integration
- Example usage patterns once the packages are implemented

## Architecture

```
debug-mcp-symfony-example (Symfony 8.0 Application)
├── Uses debug-mcp as MCP server
├── Extends with debug-mcp-tools
├── Accesses debug-mcp-resources
└── Uses debug-mcp-prompts for code generation
```

## Installation

### Prerequisites

- PHP 8.4 or higher
- Composer
- Symfony CLI
- Go 1.21+ (for debug-mcp-go-wrapper)

### Clone and Install

```bash
# Clone the example project
git clone https://github.com/wachterjohannes/debug-mcp-symfony-example.git
cd debug-mcp-symfony-example

# Install Symfony dependencies
composer install
```

### Install debug-mcp Packages (Once Implemented)

The `composer.json` is already configured with local path repositories pointing to the sibling directories:

```json
"repositories": [
    {
        "type": "path",
        "url": "../debug-mcp",
        "options": { "symlink": false }
    },
    {
        "type": "path",
        "url": "../debug-mcp-tools",
        "options": { "symlink": false }
    },
    {
        "type": "path",
        "url": "../debug-mcp-resources",
        "options": { "symlink": false }
    },
    {
        "type": "path",
        "url": "../debug-mcp-prompts",
        "options": { "symlink": false }
    }
]
```

To add the packages once they're implemented:

```bash
composer require wachterjohannes/debug-mcp:@dev
composer require wachterjohannes/debug-mcp-tools:@dev
composer require wachterjohannes/debug-mcp-resources:@dev
composer require wachterjohannes/debug-mcp-prompts:@dev
```

## Configuration

### Claude Desktop Configuration

Once the packages are installed and the Go wrapper is built, configure Claude Desktop:

**macOS**: `~/Library/Application Support/Claude/claude_desktop_config.json`

```json
{
  "mcpServers": {
    "debug-mcp-symfony": {
      "command": "/absolute/path/to/debug-mcp-go-wrapper/debug-mcp-wrapper",
      "args": ["--cwd", "/absolute/path/to/debug-mcp-symfony-example"]
    }
  }
}
```

**Important**: Use absolute paths, not relative paths or `~`.

### Claude Code CLI Configuration

To use the debug-mcp server with Claude Code CLI, use the `claude mcp add` command:

```bash
# Add MCP server globally (available in all projects)
claude mcp add debug-mcp-symfony \
  /absolute/path/to/debug-mcp-go-wrapper/debug-mcp-wrapper \
  --args "--cwd /absolute/path/to/debug-mcp-symfony-example"

# Or add it locally to this project only
cd /path/to/debug-mcp-symfony-example
claude mcp add debug-mcp-symfony \
  /absolute/path/to/debug-mcp-go-wrapper/debug-mcp-wrapper \
  --args "--cwd $(pwd)" \
  --local
```

**List configured MCP servers**:

```bash
# List all MCP servers
claude mcp list

# Remove an MCP server
claude mcp remove debug-mcp-symfony
```

**Manual Configuration** (if needed):

Alternatively, you can manually edit the settings file:

**macOS/Linux**: `~/.claude/settings.json`
**Windows**: `%USERPROFILE%\.claude\settings.json`

```json
{
  "mcpServers": {
    "debug-mcp-symfony": {
      "command": "/absolute/path/to/debug-mcp-go-wrapper/debug-mcp-wrapper",
      "args": ["--cwd", "/absolute/path/to/debug-mcp-symfony-example"]
    }
  }
}
```

**Verifying Configuration**:

1. Start Claude Code in this project directory
2. Check that the MCP server starts automatically
3. Use tools/resources/prompts via natural language

**Troubleshooting Claude Code CLI**:

- Check MCP server status: Look for connection messages in Claude Code output
- View server logs: Check stderr output from the Go wrapper
- Test direct execution: Run `./debug-mcp-wrapper --cwd=...` to verify it works

### Environment Variables

Create `.env.local` for environment-specific configuration:

```bash
# App environment
APP_ENV=dev
APP_SECRET=change_me_to_a_random_string

# debug-mcp configuration (if needed)
DEBUG_MCP_LOG_LEVEL=debug
```

## Project Structure

```
debug-mcp-symfony-example/
├── bin/
│   └── console              # Symfony console
├── config/
│   ├── packages/            # Package configuration
│   └── services.yaml        # Service definitions
├── public/
│   └── index.php            # Web entry point
├── src/
│   ├── Command/             # Symfony commands (generated via prompts)
│   ├── Controller/          # Controllers
│   └── Kernel.php           # Application kernel
├── var/
│   ├── cache/               # Application cache
│   └── log/                 # Application logs
├── .env                     # Environment configuration
├── composer.json            # Dependencies and repositories
└── README.md                # This file
```

## Usage Examples

### Once Packages Are Implemented

#### 1. Using Tools via Claude

With Claude Desktop configured:

```
You: "What time is it in New York?"
Claude: [Uses ClockTool from debug-mcp-tools]

You: "What PHP extensions are loaded?"
Claude: [Uses PhpConfigTool]
```

#### 2. Accessing Resources

```
You: "Show me PHP best practices"
Claude: [Retrieves php://docs/best-practices resource]

You: "How do I create a Symfony console command?"
Claude: [Retrieves symfony://docs/console-commands resource]
```

#### 3. Using Prompts for Code Generation

```
You: "Create a Symfony command called app:import-users that imports users from CSV"
Claude: [Uses symfony_command prompt with interactive=true]
```

## Available MCP Features (When Implemented)

### Tools (from debug-mcp-tools)

- **clock**: Get current time with customizable format and timezone
- **php_config**: Inspect PHP configuration, extensions, and environment

### Resources (from debug-mcp-resources)

- **php://docs/best-practices**: Modern PHP development guidelines
- **php://docs/common-patterns**: PHP design patterns and idioms
- **symfony://docs/console-commands**: Symfony Console component guide
- **symfony://docs/dependency-injection**: Symfony DI container guide

### Prompts (from debug-mcp-prompts)

- **symfony_command**: Generate Symfony Console Commands with best practices

## Development

### Running the Symfony App

```bash
# Start Symfony development server
symfony server:start

# Or use PHP built-in server
php -S localhost:8000 -t public/
```

### Creating Commands

You can use the MCP prompts to generate Symfony commands, or create them manually:

```bash
php bin/console make:command app:example
```

### Adding Custom MCP Extensions

To add your own tools/resources/prompts:

1. Create PHP classes in the `mcp/` directory (will be created)
2. Use MCP attributes (#[McpTool], #[McpResource], #[McpPrompt])
3. Classes will be auto-discovered by debug-mcp server

Example:

```php
<?php
// mcp/MyCustomTool.php
namespace Local;

use PhpMcp\Server\Attributes\McpTool;

class MyCustomTool
{
    #[McpTool(
        name: 'my_custom_tool',
        description: 'Does something useful'
    )]
    public function execute(string $input): array
    {
        return ['result' => 'Processed: ' . $input];
    }
}
```

## Testing

### Manual Testing

Once implemented, test the MCP server directly:

```bash
# Test PHP MCP server directly
cd /path/to/debug-mcp
php bin/debug-mcp

# In another terminal, send JSON-RPC messages
echo '{"jsonrpc":"2.0","method":"tools/list","id":1}' | php bin/debug-mcp
```

### Integration Testing

1. Configure Claude Desktop with the example project
2. Restart Claude Desktop
3. Verify tools, resources, and prompts are available
4. Test actual usage via natural language

## Troubleshooting

### Packages Not Found

If composer can't find the debug-mcp packages:
- Verify the sibling directories exist (`../debug-mcp`, etc.)
- Check that path repositories are configured in `composer.json`
- Ensure packages have been pushed to their GitHub repositories

### PHP Process Issues

If the PHP MCP server won't start:
- Check PHP version: `php -v` (must be 8.4+)
- Verify composer dependencies are installed
- Check logs in `var/log/`
- Run `php bin/debug-mcp` directly to see errors

### Go Wrapper Issues

If the Go wrapper fails:
- Build the wrapper: `cd ../debug-mcp-go-wrapper && make build`
- Verify working directory in Claude config is correct
- Check wrapper logs (stderr output)

## Repository Structure

This example is part of the debug-mcp ecosystem:

- **debug-mcp**: Core MCP server - [github.com/wachterjohannes/debug-mcp](https://github.com/wachterjohannes/debug-mcp)
- **debug-mcp-tools**: Debugging tools - [github.com/wachterjohannes/debug-mcp-tools](https://github.com/wachterjohannes/debug-mcp-tools)
- **debug-mcp-resources**: Documentation resources - [github.com/wachterjohannes/debug-mcp-resources](https://github.com/wachterjohannes/debug-mcp-resources)
- **debug-mcp-prompts**: Code generation prompts - [github.com/wachterjohannes/debug-mcp-prompts](https://github.com/wachterjohannes/debug-mcp-prompts)
- **debug-mcp-go-wrapper**: Process manager - [github.com/wachterjohannes/debug-mcp-go-wrapper](https://github.com/wachterjohannes/debug-mcp-go-wrapper)
- **debug-mcp-symfony-example**: This example - [github.com/wachterjohannes/debug-mcp-symfony-example](https://github.com/wachterjohannes/debug-mcp-symfony-example)

## Contributing

Since these are prototype packages for discussion:
1. Open issues for architectural discussions
2. Submit PRs for documentation improvements
3. Share feedback on the design approach

## License

MIT
