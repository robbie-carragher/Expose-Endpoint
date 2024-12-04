# Expose Future Events EventOn Endpoint Plugin

## Overview

The **Expose Future Events EventOn Endpoint** plugin adds a custom REST API endpoint to your WordPress site. This endpoint exposes all upcoming events from the **EventOn** plugin in a JSON format, which can be accessed via `/wp-json/events/all-events`. The plugin provides an easy way to retrieve event data for use in external applications, mobile apps, or custom integrations.

## Features

- Exposes all upcoming events from the **EventOn** plugin via a custom REST API endpoint.
- Retrieves essential event information, such as:
  - Event title and content
  - Start and end dates
  - Event image (if available)
  - Event location and address
  - Event categories
  - Featured status and other custom fields
- The endpoint is publicly accessible, meaning it can be accessed without authentication.

## Installation

1. Download the plugin or clone this repository.
   
   ```bash
   
