<template>
    <div class="container-fluid">
        <div id="accourding" class="d-flex justify-content-center">
            <div class="card w-75">
                <div class="card-header">
                    <h5 class="mb-0">
                        <button class="btn btn-link w-100 text-left text-dark text-decoration-none" data-toggle="collapse" data-target="#buatEvent">
                            Buat Event
                        </button>
                    </h5>
                </div>
                <div class="collapse" id="buatEvent">
                    <form @submit.prevent="createEvent()">
                    <div class="row p-4">
                        <div class="col-md">
                            <div class="form-group">
                              <input v-model="buatEvent.name_event" type="text" class="form-control" placeholder="Nama Event" aria-describedby="helpId">
                              <small v-if="error.name_event" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.name_event[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                              <input v-model="buatEvent.address" type="text" class="form-control" placeholder="Alamat" aria-describedby="helpId">
                              <small v-if="error.address" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.address[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea v-model="buatEvent.description" cols="30" rows="10" class="form-control" placeholder="Deskripsi event.."></textarea>
                                <small v-if="error.description" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.description[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input v-model="buatEvent.date" type="date" class="form-control" placeholder="Tanggal Pelaksanaan">
                                <small v-if="error.date" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.date[0] }}</small>
                            </div>
                        </div>
                        <div class="col-md">
                            <img v-if="preview" :src="preview" style="max-width:500px; max-height:250px; margin-bottom: 10px" class="img-thumbnail rounded">
                            <div class="form-group">
                                <input type="file" class="form-control gambar" @change="previewImg" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100 text-uppercase">tambahkan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-md-3 mb-4" v-for="event in events">
                <div class="card border-none shadow" style="font-size: small;">
                    <img class="card-img-top" :src="'images/' + event.image_url" alt="" height="180px" style="object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: 600;">{{ event.name_event }}</h5>
                        <p class="card-text" style="font-weight: 400;">
                            <span><i class="fa fa-address-book mr-2" aria-hidden="true"></i> {{ event.address }}</span><br>
                            <span><i class="fa fa-clock mr-2" aria-hidden="true"></i> {{ event.date }}</span>
                        </p>
                        <p class="card-text" style="font-weight: 400;">
                            {{ event.description.substring(0,100)+"..." }}
                        </p>
                    </div>
                    <div class="card-footer text-right">
                        <button @click.prevent="more(event.id)" class="rounded-circle text-light btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        <button @click.prevent="editEvent(event.id)" data-toggle="modal" data-target="#modelEdit" class="rounded-circle text-light btn btn-warning"><i class="fas fa-edit    "></i></button>
                        <button @click.prevent="deleteEvent(event.id)" class="rounded-circle text-light btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Event</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <form @submit.prevent="update(updateEvent.id)">
                                <div class="modal-body">
                                    <div class="row p-4">
                                        <div class="col-md">
                                            <div class="form-group">
                                            <input v-model="updateEvent.name_event" type="text" class="form-control" placeholder="Nama Event" aria-describedby="helpId">
                                            <small v-if="error.name_event" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.name_event[0] }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-group">
                                            <input v-model="updateEvent.address" type="text" class="form-control" placeholder="Alamat" aria-describedby="helpId">
                                            <small v-if="error.address" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.address[0] }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea v-model="updateEvent.description" cols="30" rows="10" class="form-control" placeholder="Deskripsi event.."></textarea>
                                                <small v-if="error.description" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.description[0] }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input v-model="updateEvent.date" type="date" class="form-control" placeholder="Tanggal Pelaksanaan">
                                                <small v-if="error.date" class="bg-danger w-100 px-4 py-2 text-light d-block mt-2 rounded">{{ error.date[0] }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary w-100 text-uppercase">tambahkan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            events: [],
            buatEvent: {
                name_event: '',
                address: '',
                date: '',
                // image_url: '',
                description: '',
            },
            updateEvent: {},
            error: {},
            authUser: window.authUser,
            preview: '',
            photo: null
        }
    },
    mounted(){
        this.getEvents()
    },
    methods: {
        reset(){
            this.buatEvent.name_event = '',
            this.buatEvent.address = '',
            this.buatEvent.date = '',
            this.buatEvent.description = '',
            $('.gambar').val('')
            this.preview = null
        },
        getEvents(){
            axios.get('/api/home').then((response)=>{
                this.events = response.data
            });
        },
        createEvent(){
            axios.post('/api/create', this.buatEvent).then((response)=>{
                if(response.data.status){
                    this.upload(response.data.data.id)
                    this.$swal({
                        title: 'Successfully',
                        text: response.data.message,
                        icon: 'success'
                    })
                    this.reset()
                    this.getEvents()
                }
            }).catch((errors)=>{
                if(!errors.response.data.status){
                    this.error = errors.response.data.message
                }
            })
        },
        deleteEvent(id){
            this.$swal({
                title: "Apakah Anda Yakin?",
                text: "Setelah dihapus, Anda tidak dapat memulihkan event ini!",
                icon: "warning",
                showDenyButton: true,
            }).then((result)=>{
                if(result.isConfirmed){
                    axios.delete('/api/delete/' + id).then((response)=>{
                        this.$swal({
                            title: 'Successfully',
                            text: response.data.message,
                            icon: 'success'
                        });
                        this.getEvents()
                    })
                }else{
                    return false
                }
            })
        },
        editEvent(id){
            axios.get('/api/edit/' + id).then((response)=>{
                this.updateEvent = response.data
                console.log(this.updateEvent);
            })
        },
        update(id){
            axios.put('/api/update/' + id, this.updateEvent).then((response)=>{
                if(response.data.status){
                    this.$swal({
                        title: 'Successfully',
                        text: response.data.message,
                        icon: 'success'
                    })
                    $('#modelEdit').modal('toggle')
                    this.reset()
                    this.getEvents()
                }
            }).catch((errors)=>{
                if(!errors.response.data.status){
                    this.error = errors.response.data.message
                }
            })
        },
        more(id){
            this.$router.push({
                name: 'detail',
                params: {id}
            })
        },
        previewImg(e){
            let file = e.target.files[0]
            this.preview = URL.createObjectURL(file)
            this.photo = file
        },
        upload(id){
            let formData = new FormData()
            formData.append('photo', this.photo)

            axios.post('/api/upload/' + id, formData)
        }

    }
}
</script>

