<div action="#" id="compose-form" wire:ignore.self>
    <div class="card-content">
        <div class="card-body pt-0">
            <div class="form-label-group">
                <input type="email" id="emailTo" wire:model='to' class="form-control" placeholder="To" required>
                <label for="emailTo">To</label>
                @error('to')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-label-group">
                <input type="email" id="emailTo" wire:model='subject' class="form-control" placeholder="Subject"
                    required>
                <label for="emailTo">Subject</label>
                @error('subject')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Compose mail Quill editor -->

            <div class="row px-2" wire:ignore>
                <!-- quill editor for reply message -->
                <div class="col-12 px-0">
                    <div class="card shadow-none border rounded">
                        {{--  <div class="card-body quill-wrapper">  --}}

                        <textarea wire:model="replyMessage" id="editor" cols="30" rows="10"></textarea>
                        @error('replyMessage')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        {{--  </div>  --}}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input multiple wire:model='attachments' type="file" class="custom-file-input">
                    <label class="custom-file-label" for="emailAttach">Attach
                        file</label>
                </div>

            </div>
            <div class="row">
                @foreach ($files as $key => $emailFile)
                    <div class="col-md-3">
                        <img src="file.png">
                        <button class="btn btn-danger" wire:click="delteIndex({{ $key }})">Delete</button>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
    <div class="card-footer d-flex justify-content-end pt-0">
        <button type="reset" class="btn btn-light-secondary cancel-btn mr-1">
            <i class='bx bx-x mr-25'></i>
            <span class="d-sm-inline d-none">Cancel</span>
        </button>
        {{-- <button wire:loading.attr='disabled' wire:target='send'
        wire:click='send'  type="submit" class="btn-send btn btn-primary">
            <i class='bx bx-send mr-25'></i> <span class="d-sm-inline d-none">Send</span>
        </button> --}}
        <button wire:target='send' wire:click='send' class="btn btn-primary" type="button"
            wire:loading.attr='disabled'>
            <span wire:loading.remove>Send</span>
            <div wire:loading>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </div>

        </button>
    </div>
</div>
@livewireScripts

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
    //     .then( editor => {
    //     editor.ui.view.editable.element.style.height = '250px';
    // } )
              .then(editor => {
                editor.model.document.on('change:data', () => {
                    @this.set('replyMessage', editor.getData());
                });
            })

        .catch( error => {
            console.error( error );
        } );
</script>
