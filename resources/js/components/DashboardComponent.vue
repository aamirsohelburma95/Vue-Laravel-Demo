<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Property</h2>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label>Property Title</label>
                                <div class="input-group">
                                    <input class="form-control" v-model="property_title" type="text" id="property"
                                        name="property" placeholder="Casa faroda" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label>Property Rent (Per/Day)</label>
                                <div class="input-group">
                                    <input class="form-control" v-model="property_rent" type="number" id="rent"
                                        name="rent" placeholder="9500" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label>Property photo</label>
                                <div class="input-group">
                                    <input class="form-control" accept="image/*" @change="onChange" type="file" id="photo" name="photo"
                                        placeholder="Property photo" ref="image" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Property Address</label>
                                    <textarea v-model="property_address" class="form-control" name="address"
                                        id="address" rows="3"
                                        placeholder="919 Timbercrest Road, Border City, AK"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Property Description</label>
                                    <textarea class="form-control" v-model="property_desc" name="desc" id="desc"
                                        rows="3"
                                        placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button v-if="!edit_property_id" type="button" @click="saveProperty()"
                                        class="btn btn-outline-success ">
                                        Add Property
                                    </button>
                                    <button v-else type="button" @click="updateProperty()"
                                        class="btn btn-outline-warning ">
                                        Update Property
                                    </button>
                                    <button type="button" @click="resetProperty()"
                                        class="btn btn-outline-danger btn-reset ">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="divider" />
                        <div>
                            <img :src="div_image" style="width:100%;" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Property Details</h2>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-strapped table-bordered">
                                        <thead>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Rent</th>
                                            <th>Photo</th>
                                            <th>Address</th>
                                            <th>Desc</th>
                                            <th>Action</th>
                                        </thead>
                                        <tfoot>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Rent</th>
                                            <th>Photo</th>
                                            <th>Address</th>
                                            <th>Desc</th>
                                            <th>Action</th>
                                        </tfoot>
                                        <tbody class="table-responsive table-body">
                                            <tr v-for="(property, index) in properties" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ property.title }}</td>
                                                <td>{{ property.price }}</td>
                                                <td><img class="min-image" :src=" '/images/'+ property.photo" /> </td>
                                                <td>{{ property.Address }}</td>
                                                <td>{{ property.Desc }}</td>
                                                <td>
                                                    <button @click="editProperty(index)"
                                                        class="btn btn-outline-warning mb-3"><i class="fa fa-pencil"
                                                            aria-hidden="true"></i></button>
                                                    <button @click="deleteProperty(index)"
                                                        class="btn btn-outline-danger mb-3"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    data() {
        return {
            properties: [],
            api: 'http://127.0.0.1:8000/api/properties',
            property_title: "",
            property_rent: "",
            property_address: "",
            property_photo: null,
            property_desc: "",
            edit_property_id: "",
            edit_property_index: "",
            div_image:null
        }
    },

    mounted() {
        // get API data
        this.axios.get(this.api).then(res => {
            this.properties = res.data;
        });
    },
    methods: {
        saveProperty() {
            if (isNaN(this.property_rent) || !this.property_rent) {
                alert("Rent must be on number formate");
                return;
            }
            if (this.property_title && this.property_rent && this.property_address && this.property_desc && this.property_photo) {
                let formData = new FormData();
                formData.append("title",this.property_title);
                formData.append("price",this.property_rent);
                formData.append("photo",this.property_photo);
                formData.append("Address",this.property_address);
                formData.append("Desc",this.property_desc);
                this.axios.post(this.api, formData).then(res => {
                    this.properties.push(res.data);
                    this.emptyInputData();
                }).catch(err => alert(err));
            } else {
                alert("All fields are required!");
            }
        },
        emptyInputData() {
            this.property_title = "";
            this.property_rent = "";
            this.property_address = "";
            this.property_desc = "";
            this.property_photo = null;
            this.div_image = null;
            this.$refs.image.value=null;
        },
        deleteProperty(index) {
            if (this.properties[index].id) {
                this.axios.delete(this.api + "/" + this.properties[index].id).then(res => {
                    console.log(res);
                    this.properties.splice(index, 1);
                })
            }
        },
        editProperty(index) {
            if (this.properties[index].id) {
                this.property_title = this.properties[index].title;
                this.property_rent = this.properties[index].price;
                this.property_photo = this.properties[index].photo;
                this.property_address = this.properties[index].Address;
                this.property_desc = this.properties[index].Desc;
                this.edit_property_id = this.properties[index].id;
                this.edit_property_index = index;
            }
            this.div_image = '/images/' + this.property_photo
            console.log(this.property_photo);
        },
        updateProperty() {
            if (isNaN(this.property_rent) || !this.property_rent) {
                alert("Rent must be on number formate");
                return;
            }
            if (this.property_title && this.property_rent && this.property_address && this.property_desc) {

                let formData = new FormData();
                
                formData.append("_method","PATCH");
                formData.append("form ","form");
                formData.append("title",this.property_title);
                formData.append("price",this.property_rent);
                formData.append("photo",this.property_photo);
                formData.append("Address",this.property_address);
                formData.append("Desc",this.property_desc);
                console.log(this.property_photo);
                this.axios.post(this.api + "/" + this.properties[this.edit_property_index].id, formData).then(res => {

                    this.properties[this.edit_property_index].title = res.data.title;
                    this.properties[this.edit_property_index].price = res.data.price;
                    this.properties[this.edit_property_index].Address = res.data.Address;
                    this.properties[this.edit_property_index].Desc = res.data.Desc;
                    this.properties[this.edit_property_index].photo = res.data.photo;
                    this.emptyInputData();
                    this.resetProperty();
                })
            } else {
                alert("All fields are required!");
            }
        },
        resetProperty() {
            this.emptyInputData();
            this.edit_property_id = "";
            this.edit_property_index = "";
        },
        onChange(e) {
            console.log("Selected File", e.target.files[0]);
            this.property_photo = e.target.files[0];
        }
    },
};
</script>
<style >
.min-image{
    width: 150px;
}
</style>