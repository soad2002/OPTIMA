#!/usr/bin/env python3
"""Clean JavaScript files by removing Arabic comments and formatting"""

import re
import os

def clean_js_file(filepath):
    """Remove Arabic comments and clean up formatting"""
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Remove lines that are entirely Arabic comments
    lines = content.split('\n')
    cleaned_lines = []
    
    for line in lines:
        # Skip lines that appear to be just comment sections with Arabic text
        if '//' in line:
            # Extract the comment part
            code_part, comment_part = line.split('//', 1)
            # Check if comment is mostly Arabic
            arabic_pattern = r'[\u0600-\u06FF]'
            arabic_count = len(re.findall(arabic_pattern, comment_part))
            
            # If comment is more than 50% Arabic and is just a comment block marker, skip it
            if arabic_count > len(comment_part.strip()) * 0.5 and code_part.strip() == '':
                continue
            # Otherwise keep the line but remove Arabic parts
            else:
                # Keep the line but it's okay if it has some Arabic in comments
                cleaned_lines.append(line)
        else:
            # Check if line is entirely Arabic comment block
            if re.search(r'^[\s/=\-]*[\u0600-\u06FF]+[\s/=\-]*$', line):
                continue
            cleaned_lines.append(line)
    
    # Join back and remove extra blank lines
    content = '\n'.join(cleaned_lines)
    content = re.sub(r'\n\s*\n\s*\n+', '\n\n', content)
    
    # Replace Arabic comment markers with English ones
    content = content.replace('// دوال المساعدة', '// Helper Functions')
    content = content.replace('// إعدادات API', '// API Configuration')
    content = content.replace('// تحميل', '// Load')
    content = content.replace('// عرض', '// Display')
    content = content.replace('// جلب', '// Fetch')
    
    return content

def main():
    js_dir = r'c:\xampp\htdocs\Optima\public\js'
    files_to_clean = ['cart.js', 'checkout.js', 'account.js', 'product.js', 
                      'compare.js', 'index.js']
    
    for filename in files_to_clean:
        filepath = os.path.join(js_dir, filename)
        if os.path.exists(filepath):
            print(f"Cleaning {filename}...")
            cleaned = clean_js_file(filepath)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(cleaned)
            print(f"  ✓ Cleaned {filename}")
        else:
            print(f"  ✗ File not found: {filename}")
    
    print("\nCleanup complete!")

if __name__ == '__main__':
    main()
