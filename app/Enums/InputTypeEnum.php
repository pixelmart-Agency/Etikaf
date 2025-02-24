<?php

namespace App\Enums;

enum InputTypeEnum: string
{
        // Basic Input Types
    case TEXT = 'text';
    case NUMBER = 'number';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case TEL = 'tel'; // Phone number input
    case URL = 'url'; // URL input
    case SEARCH = 'search'; // Search input field
    case DATE = 'date'; // Date input field
    case TIME = 'time'; // Time input field
    case DATETIME = 'datetime-local'; // Date and Time input
    case COLOR = 'color'; // Color input

        // File Input Types
    case FILE = 'file'; // File input
    case IMAGE = 'image'; // Image input (for file uploading with preview)

        // Checkbox & Radio Types
    case CHECKBOX = 'checkbox'; // Checkbox input
    case RADIO = 'radio'; // Radio button input

        // Range & Other Special Input Types
    case RANGE = 'range'; // Range slider input
    case HIDDEN = 'hidden'; // Hidden input
    case BUTTON = 'button'; // Button input
    case SUBMIT = 'submit'; // Submit button
    case RESET = 'reset'; // Reset button

        // Select / Multiple Inputs
    case SELECT = 'select'; // Drop-down select input
    case MULTIPLE = 'multiple'; // Multi-select input
}
