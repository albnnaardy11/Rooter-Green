@props(['name', 'value' => ''])

<div class="w-full">
    <textarea name="{{ $name }}" id="editor-{{ $name }}" class="hidden">{{ $value }}</textarea>
</div>

@once
    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editors = document.querySelectorAll('[id^="editor-"]');
            editors.forEach(el => {
                ClassicEditor
                    .create(el, {
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                                'outdent', 'indent', '|',
                                'blockQuote', 'insertTable', 'undo', 'redo'
                            ]
                        },
                        language: 'en',
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        }
                    })
                    .then(editor => {
                        window.cmsEditors = window.cmsEditors || {};
                        window.cmsEditors['{{ $name }}'] = editor;
                        
                        editor.model.document.on('change:data', () => {
                            const data = editor.getData();
                            el.value = data;
                            // Trigger change event for Alpine.js or other listeners
                            el.dispatchEvent(new Event('input', { bubbles: true }));
                            el.dispatchEvent(new Event('change', { bubbles: true }));
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
    <style>
        /* CKEditor 5 Dark Mode Branding */
        :root {
            --ck-color-base-foreground: #1e293b;
            --ck-color-base-background: #0f172a;
            --ck-color-base-border: rgba(255, 255, 255, 0.1);
            --ck-color-base-action: #fb7185;
            --ck-color-base-active: #e11d48;
            --ck-color-base-active-focus: #be123c;
            --ck-color-base-error: #db2777;
            --ck-color-focus-border: #f43f5e;
            --ck-color-focus-outer-shadow: rgba(244, 63, 94, 0.2);
            
            --ck-color-toolbar-background: #1e293b;
            --ck-color-toolbar-border: rgba(255, 255, 255, 0.1);
            
            --ck-color-button-default-hover-background: #334155;
            --ck-color-button-default-active-background: #475569;
            --ck-color-button-on-background: #475569;
            --ck-color-button-on-hover-background: #64748b;
            
            --ck-color-input-background: #0f172a;
            --ck-color-input-border: rgba(255, 255, 255, 0.1);
            --ck-color-input-text: #f1f5f9;
            --ck-color-input-placeholder: #64748b;
            
            --ck-color-list-background: #1e293b;
            --ck-color-list-button-hover-background: #334155;
        }

        .ck-reset_all, .ck-reset_all * {
            color: #f1f5f9 !important;
        }

        .ck-editor__editable {
            background-color: rgba(255, 255, 255, 0.03) !important;
            border-bottom-left-radius: 1.5rem !important;
            border-bottom-right-radius: 1.5rem !important;
            min-height: 400px !important;
            padding: 2rem !important;
            color: #f1f5f9 !important;
            font-size: 1.125rem !important;
            line-height: 1.75 !important;
        }

        .ck-toolbar {
            background-color: rgba(255, 255, 255, 0.07) !important;
            border-top-left-radius: 1.5rem !important;
            border-top-right-radius: 1.5rem !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            padding: 0.75rem !important;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .ck.ck-editor__main>.ck-editor__editable.ck-focused {
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb), 0.1) !important;
        }

        .ck.ck-button:not(.ck-disabled):hover,
        a.ck.ck-button:not(.ck-disabled):hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .ck.ck-button.ck-on,
        a.ck.ck-button.ck-on {
            background: var(--color-primary) !important;
            color: white !important;
        }

        /* Content Styling */
        .ck-content h2 { font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem; color: white; }
        .ck-content h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: white; }
        .ck-content p { margin-bottom: 1.25rem; }
        .ck-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.25rem; }
        .ck-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1.25rem; }
        .ck-content blockquote { border-left: 4px solid var(--color-primary); padding-left: 1.5rem; font-style: italic; margin-bottom: 1.25rem; color: #94a3b8; }
    </style>
    @endpush
@endonce
