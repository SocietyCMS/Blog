<div class="ui styled fluid accordion">

    <div class="title">
        <i class="dropdown icon"></i>
        @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.photo')])
    </div>
    <div class="content">

        <div class="ui blue transition visible" id="blogImagesSegment">

            <div class="ui basic segment" id="imagesToolbar">
            </div>

            <div class="ui grid qq-upload-drop-area" id="blogImages">
                <div class="eight wide tablet two wide computer photo column" v-for="photo in album"
                     v-bind:class="{'selected': photo == detailPhoto }" v-on:click="detail(photo)">
                    <a class="ui basic photo raised segment">
                        <div class="photo image"><img class="ui medium bordered image"
                                                      v-bind:src="photo.thumbnail.medium"></div>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="title">
        <i class="dropdown icon"></i>
        @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
    </div>
    <div class="content" id="uploadFilesSection">
        <div class="transition hidden">

            <div class="ui basic button" id="uploadFileButton">
                <i class="icon photo"></i>
                @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
            </div>
            <div class="ui red basic right floated button" id="deleteFileButton"
                 style="display: none"> @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.photo')])</div>

            <div class="ui indicating right floated progress" id="uploadFileProgrssbar" style="display: none">
                <div class="bar"></div>
                <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.files')])</div>
            </div>

            <div v-if="files.length > 0">
                <div class="ui divider"></div>

                <table class="ui selectable table" id="blogFiles">
                    <tbody>
                    <tr v-for="file in files">
                        <td>
                            <i class="@{{ fileClass(file.mime_type) }} icon"></i> @{{ file.file_name  }}
                        </td>
                        <td class="right aligned">
                            <button class="ui basic icon button" v-on:click="deleteFile(file)">
                                <i class="trash icon"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
