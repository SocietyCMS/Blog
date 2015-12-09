<div class="ui blue segment" id="blogFilesSegment">

    <div class="ui basic segment" id="filesToolbar">

        <div class="ui basic button" id="uploadFileButton">
            <i class="icon photo"></i>
            @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
        </div>
        <div class="ui red basic right floated button" id="deleteFileButton" style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>


        <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadFileProgrssbar" style="display: none">
            <div class="bar"></div>
            <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.files')])</div>
        </div>
    </div>

    <div class="ui grid qq-upload-drop-area" id="blogFiles">
        <div class="eight wide tablet two wide computer photo column"  v-for="file in files" v-bind:class="{'selected': file == detailFile }" v-on:click="detail(file)">
            <a class="ui basic file raised segment">
                <i class="massive file image outline icon"></i> @{{ file.file_name }}
            </a>
        </div>
    </div>

</div>


