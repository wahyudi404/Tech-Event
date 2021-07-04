<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card border-none shadow" style="font-size: small;">
                    <img class="card-img-top" height="400px" style="object-fit: cover;" :src="'../images/' + event.image_url" alt="">
                    <div class="card-body">
                        <h5 class="card-title">{{ event.name_event }}</h5>
                        <p class="card-text">
                            <span><i class="fa fa-address-book mr-2" aria-hidden="true"></i> {{ event.address }}</span><br>
                            <span><i class="fa fa-clock mr-2" aria-hidden="true"></i> {{ event.date }}</span>
                        </p>
                        <p class="card-text">
                            {{ event.description }}
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <div class="d-flex justify-content-end">
                            <div v-if="auth">
                            <button v-if="auth.role_id == 1" data-toggle="modal" data-target="#modelEditGambar" class="btn btn-warning text-dark mr-2">EDIT GAMBAR</button>
                            <form v-if="auth.role_id == 1" @submit.prevent="upload()">
                                <div class="modal fade" id="modelEditGambar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">EDIT GAMBAR</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <img v-if="preview" :src="preview" style="max-width:400px; max-height: 300px; object-fit: cover;" class="img-thumbnail mb-2">
                                                <div class="form-group">
                                                  <input type="file" @change.prevent="previewImg" class="form-control gambar" aria-describedby="helpId" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <form @submit.prevent="eventUser()" v-if="!(join.length)">
                                <button v-if="auth" type="submit" class="btn btn-info text-light">JOIN</button>
                                <button v-else class="btn btn-info text-light" disabled>JOIN</button>
                            </form>
                        </div>
                        <!-- <form @submit.prevent="deleteEventUser()" v-else>
                            <button v-if="auth" type="submit" class="btn btn-danger text-light">BATAL JOIN</button>
                            <button v-else class="btn btn-danger text-light" disabled>BATAL JOIN</button>
                        </form> -->
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['id'],
    data(){
        return{
            event: {},
            auth: window.authUser,
            eventUs: {
                user_id: '',
                event_id: ''
            },
            join: {},
            preview: '',
            photo: null
        }
    },
    mounted(){
        this.getEvents()
        if(this.auth){
            this.getEventUser()
        }
    },
    methods: {
        reset(){
            $('.gambar').val('')
            this.preview= ''
        },
        getEvents(){
            axios.get('/api/edit/' + this.id).then((response)=>{
                this.event = response.data
                if(this.auth){
                    this.eventUs.user_id = this.auth.id
                }else{
                    this.eventUs.user_id = null
                }
                this.eventUs.event_id = this.id
            });
        },
        getEventUser(){
            axios.get('/api/event/'+ this.auth.id + '/' + this.id).then((response)=>{
                this.join = response.data
            })
        },
        eventUser(){
            axios.post('/api/event', this.eventUs).then((response)=>{
                if(response.data.status){
                    this.$swal({
                        title: 'Success',
                        text: response.data.message,
                        icon: 'success'
                    })
                    this.getEvents()
                    this.getEventUser()
                }
            })
        },
        previewImg(e){
            let files = e.target.files[0]
            this.preview = URL.createObjectURL(files)
            this.photo = files
        },
        upload(){
            let formData = new FormData()
            formData.append('photo', this.photo)

            axios.post('/api/upload/' + this.id, formData).then((response)=>{
                this.$swal({
                    title: 'Successfully',
                    text: 'Gambar Berhasil Diubah!',
                    icon: 'success'
                })
                $('#modelEditGambar').modal('toggle')
                this.reset()
                this.getEvents()
            })
        }
    }
}
</script>
