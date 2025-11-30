# debug-mcp-symfony-example - MCP Server Demo Project

## MCP Resources Priority

**IMPORTANT**: This project has an MCP server (`debug-mcp-symfony`) with documentation resources. When the user asks for documentation or information about PHP or Symfony topics, ALWAYS check MCP resources FIRST before using web search or other methods.

### Available MCP Resources

#### Static Resources
- `php://docs/index` - Lists all available PHP documentation topics
- `symfony://docs/index` - Lists all available Symfony documentation topics
- `test://info/about` - Information about the MCP server
- `test://info/help` - Help for using the MCP server

#### Resource Templates (Dynamic)
- `php://docs/{topic}` - PHP documentation (topics: best-practices, common-patterns)
- `symfony://docs/{topic}` - Symfony documentation (topics: console-commands, dependency-injection)

#### Topic Aliases
For easier access, the following aliases are supported:
- `console` → `console-commands`
- `di` or `dependency` → `dependency-injection`
- `best` or `practices` → `best-practices`
- `patterns` → `common-patterns`

### Usage Pattern

When user asks for documentation (e.g., "Show me Symfony console documentation"):

1. **FIRST**: Check if it matches an MCP resource topic
2. **READ** the appropriate resource using `readMcpResource`
3. **ONLY IF** not available in MCP: fall back to web search

### Examples

**User Query**: "Show me Symfony console documentation"
**Correct Action**: Read `symfony://docs/console` or `symfony://docs/console-commands`

**User Query**: "What are PHP best practices?"
**Correct Action**: Read `php://docs/best-practices`

**User Query**: "How do I use dependency injection in Symfony?"
**Correct Action**: Read `symfony://docs/dependency-injection`

### Tools Available

The MCP server provides these tools:
- `clock` - Get current time with timezone support
- `php_config` - Show PHP configuration and loaded extensions
- `test_tool` - Simple test tool

### Resource Discovery

If unsure what resources are available:
1. List MCP resources: `listMcpResources()`
2. Read index: `readMcpResource("symfony://docs/index")` or `readMcpResource("php://docs/index")`
3. The index will show all available topics and aliases

## Project Context

This is a Symfony 8.0 example project demonstrating MCP server integration for PHP development. The MCP server auto-discovers:
- Tools/resources/prompts from vendor packages (debug-mcp-tools, debug-mcp-resources, debug-mcp-prompts)
- Local extensions from the `mcp/` directory

## Development Guidelines

When working in this project:
- Use MCP resources for documentation instead of web search
- Add custom tools in `mcp/` directory (auto-discovered)
- Test MCP features using the examples in README.md
