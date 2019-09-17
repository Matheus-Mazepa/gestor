<div class="box-editor">
    <div class="auxiliary-components">
        @include('admin.editor.components')

        <div class="component-attributes"></div>
        <input type="hidden" name="content"/>
        <div class="poster-block">
            <div id="poster-editor" class="poster-editor grid-off editor-ready">
                <editor-content></editor-content>
            </div>
            <div class="grid-rulers"></div>
        </div>
        @include('admin.editor.footer')
    </div>
</div>
