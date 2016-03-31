<div class="ui styled fluid accordion">

        <div class="title">
            <i class="dropdown icon"></i>
            @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.cover')])
        </div>
        <div class="ui content">

            <div class="ui blue transition visible" id="blogImagesSegment">

                <div class="ui basic button" id="uploadImageButton">
                    <i class="icon photo"></i>
                    @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.cover')])
                </div>

                <div class="ui red basic right floated button" id="deleteAlbumButton"  v-show="cover && cover.id">
                    @lang('core::elements.action.delete resource', ['name' => trans('blog::blog.title.cover')])
                </div>

                <div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadImageProgrssbar" style="display: none">
                    <div class="bar"></div>
                    <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.cover')])</div>
                </div>

                <div v-if="cover && cover.id">
                    <div class="ui divider"></div>

                    <div class="ui grid qq-upload-drop-area" id="blogCovers">
                        <img class="ui big centered image" v-bind:src="cover.thumbnail.medium">
                    </div>

                </div>
            </div>
        </div>


        <div class="title">
            <i class="dropdown icon"></i>
            @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
        </div>

        <div class="ui content" id="uploadFilesSection">
            <div class="transition hidden">

                <div class="ui basic button" id="uploadFileButton">
                    <i class="icon photo"></i>
                    @lang('core::elements.action.add resource', ['name' => trans('blog::blog.title.file')])
                </div>

                <div class="ui indicating right floated progress" id="uploadFileProgrssbar" style="display: none">
                    <div class="bar"></div>
                    <div class="label">@lang('core::elements.progress.uploading resource', ['name' => trans('blog::blog.title.files')])</div>
                </div>

                <div v-if="files && files.length > 0">
                    <div class="ui divider"></div>

                    <table class="ui selectable table" id="blogFiles">
                        <tbody>
                        <tr v-for="file in files">
                            <td>
                                <i v-bind:class="file.mime_type | semanticFileTypeClass" class="icon"></i>
                                @{{ file.file_name  }}
                            </td>
                            <td>
                                @{{ file.size | humanReadableFilesize }}
                            </td>
                            <td class="right aligned">
                                <a class="ui basic icon button" v-on:click="deleteFile(file)">
                                    <i class="trash icon"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>
