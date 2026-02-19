@props(['name', 'value' => ''])

<div x-data="editor(@js($value))" 
     x-init="init()"
     class="space-y-4">
    <div class="flex flex-wrap gap-2 p-4 bg-white/5 border border-white/10 rounded-2xl">
        <button type="button" @click="toggleBold()" :class="isBold ? 'bg-primary text-white' : 'text-slate-400'" class="p-2 rounded-lg hover:bg-white/10 transition-all">
            <i class="ri-bold"></i>
        </button>
        <button type="button" @click="toggleItalic()" :class="isItalic ? 'bg-primary text-white' : 'text-slate-400'" class="p-2 rounded-lg hover:bg-white/10 transition-all">
            <i class="ri-italic"></i>
        </button>
        <button type="button" @click="toggleHeading(1)" :class="isHeading(1) ? 'bg-primary text-white' : 'text-slate-400'" class="p-2 rounded-lg hover:bg-white/10 transition-all">
            <span class="font-bold">H1</span>
        </button>
        <button type="button" @click="toggleHeading(2)" :class="isHeading(2) ? 'bg-primary text-white' : 'text-slate-400'" class="p-2 rounded-lg hover:bg-white/10 transition-all">
            <span class="font-bold">H2</span>
        </button>
        <button type="button" @click="toggleBulletList()" :class="isBulletList ? 'bg-primary text-white' : 'text-slate-400'" class="p-2 rounded-lg hover:bg-white/10 transition-all">
            <i class="ri-list-unordered"></i>
        </button>
    </div>

    <div id="editor-{{ $name }}" class="prose prose-invert max-w-none w-full bg-white/5 border border-white/10 rounded-3xl min-h-[400px] p-8 text-white focus:outline-none focus:border-primary/50 transition-all"></div>
    
    <input type="hidden" name="{{ $name }}" :value="content">
</div>

@once
    @push('scripts')
    <script src="https://unpkg.com/@tiptap/standalone"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('editor', (initialContent) => ({
                editor: null,
                content: initialContent,
                isBold: false,
                isItalic: false,
                isBulletList: false,

                init() {
                    const { Editor } = window.Tiptap;
                    const { StarterKit } = window.TiptapStarterKit;
                    
                    this.editor = new Editor({
                        element: document.querySelector('#editor-{{ $name }}'),
                        extensions: [
                            StarterKit,
                        ],
                        content: this.content,
                        onUpdate: ({ editor }) => {
                            this.content = editor.getHTML();
                            this.updateState();
                        },
                        onSelectionUpdate: () => {
                            this.updateState();
                        }
                    });
                },

                updateState() {
                    this.isBold = this.editor.isActive('bold');
                    this.isItalic = this.editor.isActive('italic');
                    this.isBulletList = this.editor.isActive('bulletList');
                },

                toggleBold() { this.editor.chain().focus().toggleBold().run() },
                toggleItalic() { this.editor.chain().focus().toggleItalic().run() },
                toggleHeading(level) { this.editor.chain().focus().toggleHeading({ level }).run() },
                toggleBulletList() { this.editor.chain().focus().toggleBulletList().run() },
                isHeading(level) { return this.editor ? this.editor.isActive('heading', { level }) : false }
            }));
        });
    </script>
    @endpush
@endonce

<style>
    .ProseMirror {
        outline: none;
        min-height: 350px;
    }
    .ProseMirror p.is-editor-empty:first-child::before {
        content: attr(data-placeholder);
        float: left;
        color: #475569;
        pointer-events: none;
        height: 0;
    }
</style>
