<?php

namespace App\Mate;

use Mcp\Capability\Attribute\McpResource;

class TestResource
{
    #[McpResource(
        uri: 'test://info/about',
        name: 'test_information',
        description: 'Information about the test MCP server',
        mimeType: 'text/plain'
    )]
    public function getInfo(): string
    {
        return <<<TEXT
# Test MCP Server

This is a test resource from the debug-mcp-symfony-example project.

## Available Features

- Tools: clock, php_config, test_tool
- Prompts: symfony_command
- Resources: This one!

## How it works

The MCP server discovers:
1. Tools/resources/prompts from vendor packages
2. Local extensions from the mcp/ directory
3. Auto-registers them with the MCP protocol

You're reading this resource right now via the MCP protocol!
TEXT;
    }

    #[McpResource(
        uri: 'test://info/help',
        name: 'test_help',
        description: 'Help information for using the test server',
        mimeType: 'text/plain'
    )]
    public function getHelp(): string
    {
        return <<<TEXT
# MCP Server Help

## Using Tools

Ask Claude:
- "What time is it in Tokyo?"
- "What PHP extensions are loaded?"

## Using Prompts

Ask Claude:
- "Generate a Symfony command to process orders"

## Using Resources

Ask Claude:
- "Show me the test information resource"
- "What help is available from the test server?"

Resources are static content that Claude can read.
TEXT;
    }
}
