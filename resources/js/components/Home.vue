<template>
    <div class="container-fluid">
        <div class="row">
            <div class="center">
                <h1 class="title">CRUD WITH <span class="text-success">VUEJS</span></h1>
            </div>
            <div class="center bg-success mb-4">
                <a @click="addMode" class="btn btn-warning button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fas fa-plus-circle"></i>
                    <b>Create a new user</b>
                </a>
            </div>

            <div v-for="(item, index) in items" :key="index"  class="center">
                <div class="col-10 card shadow-sm p-2 mb-3 bg-body rounded">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <b>Name: </b>{{item.name}}
                            <br>
                            <b>Last name: </b>{{item.lastname}}
                            <br>
                            <b>Email: </b>{{item.email}}
                            <br>
                            
                        </div>
                        <div class="col-12 col-md-4">
                            <b>Action:</b>
                            <div class="row px-3">
                                <button @click="deleteMode(item.id,index)" type="button" class="col-12 col-md-3 btn btn-outline-danger  m-md-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button @click="editMode(item,index)" type="button" class="col-12 col-md-3 btn btn-outline-primary mt-2 m-md-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{title}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- New and edit -->
                        <div v-if="!successful" class="modal-body">
                            <div v-if="status =='add' || status == 'edit'">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                                        <ul v-if="errors.length != 0" class="text-danger">
                                            <li
                                                v-for="name in errors.name"
                                                :key="name.id">    
                                                {{name}}
                                            </li>
                                        </ul>
                                    <input type="text" class="form-control" id="name" placeholder="name..."
                                        v-model="user.name"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                        <ul v-if="errors.length != 0" class="text-danger">
                                            <li
                                                v-for="lastname in errors.lastname"
                                                :key="lastname.id">    
                                                {{lastname}}
                                            </li>
                                        </ul>
                                    <input type="text" class="form-control" id="lastname" placeholder="last name..."
                                        v-model="user.lastname"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                        <ul v-if="errors.length != 0" class="text-danger">
                                            <li
                                                v-for="email in errors.email"
                                                :key="email.id">    
                                                {{email}}
                                            </li>
                                        </ul>
                                    <input type="email" class="form-control" id="email" placeholder="name@example.com"
                                        v-model="user.email"
                                    >
                                </div>
                            </div>
                            <!-- Delete -->
                            <div v-else-if="status =='delete'" >
                                <div class="center text-danger">
                                    <i class="fas fa-trash-alt fa-3x"></i>
                                </div>
                                <div class="center">
                                    <h4>Are you sure to <span class="text-danger">delete</span>?</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Success-->
                        <div v-else class="modal-body">
                            <div class="center text-success">
                                <i class="fas fa-check fa-3x"></i>
                            </div>
                            <div class="center">
                                <h4>The {{messege}} action completed <span class="text-success">successfully!!</span></h4>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <div v-if="successful">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Accept</button>
                            </div>
                            <div v-else>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                <button @click="save" v-if="status == 'add'" type="button" class="btn btn-success">Record</button>
                                <button @click="edit" v-else-if="status == 'edit'" type="button" class="btn btn-success">Save changes</button>
                                <button @click="deleteItem" v-else-if="status == 'delete'" type="button" class="btn btn-danger">Delete</button>   
                            </div>
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
            user:{
                name:'',
                lastname:'',
                email:''
            },
            title:"",
            messege: '',
            idItem: '',
            indexItem:'',
            items:[],
            errors:[],
            status: null,
            successful: Boolean
        }
    },
    methods:{
        addMode(){
            this.status = 'add'
            this.title = 'New user'
            this.user = {}
            this.errors=[]
            this.successful = false
        },
        editMode(editUser,index){
            this.status = 'edit'
            this.title = 'Edit user'
            this.user = {}
            this.errors=[]

            this.indexItem = index
            this.idItem= editUser.id
            this.user.name = editUser.name
            this.user.lastname = editUser.lastname
            this.user.email = editUser.email
            this.successful = false
        },
        deleteMode(id,index){
            this.status = 'delete'
            this.title = 'Delete user'
            this.idItem= id
            this.indexItem = index
            this.successful = false
        },
        async save(){
            try {
                const res = await axios.post('user',this.user)
                if(res.data){
                    this.items.unshift(res.data)
                    this.messege = 'create'
                    this.successful = true
                }
            } catch (error) {
                if(error.response.data){
                    this.errors = error.response.data.errors
                    console.log('Tus datos son invalidos')
                }
            }  
        },
        async edit(){
            try {
                const res = await axios.put(`user/${this.idItem}`,this.user)
                if(res.data){
                    this.messege = res.data
                    this.items[this.indexItem] = this.user
                    this.successful = true
                }
            } catch (error) {
               if(error.response.data){
                    this.errors = error.response.data.errors
                    console.log('Tus datos son invalidos')
                }
            }  
        },
        async deleteItem(){
            try {
                const res = await axios.delete(`user/${this.idItem}`)
                if(res.data){
                    this.messege = res.data
                    this.items.splice(this.indexItem,1)
                    this.successful = true
                }
            } catch (error) {
                console.log('No se pudo')
            }
        },
        async load(){
            try {
                const res = await axios.get('user')
                if(res.data){
                    this.items = res.data
                }
            } catch (error) {
                console.log('No se encontro los recursos')
            }
        }
    },
    created(){
        this.load()
    }
 
}
</script>

<style scoped>
.center{
    display: flex;
    justify-content: center;
}
.title{
    margin-top: 3rem;
}
.center a{
    margin-top: 1rem;
    margin-bottom: 1rem;
}
a i{
    margin-right: 5px;
}
.button{
    display: flex;
    align-items: center;
}
</style>

