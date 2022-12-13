<template>
    <div class="container">
        <div class="card" v-if="property">
            <div class="card-header">
                <h1>Booking for : {{ this.property[0].title }}</h1>
            </div>
            <div class="card-body">
                <h4 class="card-title main-card-title text-center"><img class="img"
                        :src="'/images/' + this.property[0].photo" /></h4>
                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-5">
                        <p class="card-text"><i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            {{ this.property[0].Address }}</p>
                        <p class="card-text"><i class="fas fa-info-circle" aria-hidden="true"></i>
                            {{ this.property[0].Desc }}</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 mb-5">
                        <div class="card" style="background-color:cadetblue; border-color:darkblue;">
                            <div class="card-body">
                                <h4 class="card-title"> &#8377; {{ this.property[0].price }}</h4>
                                <div class="form-group">
                                    <label for="">Check-in Date:</label>
                                    <input type="date" @change="dateDifferent" name="" id="" v-model="checkInDate"
                                        class="form-control" placeholder="" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="">Check-out Date:</label>
                                    <input type="date" @change="dateDifferent" name="" id="" v-model="checkOutDate"
                                        class="form-control" placeholder="" aria-describedby="helpId">
                                    <small id="helpId" class="text-muted"></small>
                                </div>
                                <button @click="bookProperty"
                                    class="btn btn-lg btn-block btn-outline-dark">Reserve</button>
                            </div>
                            <div class="card-footer total text-light">
                                &#8377; {{ this.rent }} + {{ this.Difference_In_Days }} Days <span
                                    class="float-right">&#8377; {{ this.rent * this.Difference_In_Days }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                Footer
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        var date = new Date();
        // add a day
        date.setDate(date.getDate() + 1);
        return {
            property: null,
            api: 'http://127.0.0.1:8000/api/properties/' + this.$route.params.id,
            checkInDate: new Date().toISOString().slice(0, 10),
            checkOutDate: date.toISOString().slice(0, 10),
            rent: "",
            Difference_In_Days: 1,
            api2: 'http://127.0.0.1:8000/api/booking'
        }
    },
    mounted() {
        // get API data
        this.axios.get(this.api).then(res => {
            this.property = res.data;
            this.rent = this.property[0].price
        }).catch(error => this.$router.push('/'));
    },
    methods: {
        dateDifferent() {
            var date1 = new Date(this.checkInDate);
            var date2 = new Date(this.checkOutDate);
            var Difference_In_Time = date2.getTime() - date1.getTime();
            this.Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            if (this.Difference_In_Days < 1) {
                this.setDefaultDate()
                alert("Sorry! Please select valid date");
                return
            }

        },
        setDefaultDate() {
            var date = new Date();
            // add a day
            this.checkInDate = date.toISOString().slice(0, 10);
            date.setDate(date.getDate() + 1);
            this.checkOutDate = date.toISOString().slice(0, 10);
            this.rent = this.property[0].price;
            this.Difference_In_Days = 1
        },
        bookProperty() {
            let data = {
                start_date:this.checkInDate,
                end_date:this.checkOutDate,
                prop_id:this.$route.params.id
            }
            this.axios.post(this.api2, data).then(res => {
                alert("Congratulations Property booked successfully");
                this.$router.push('/')
            }).catch(error =>{
                alert("Sorry! There is a problem on booking")
            })
        }
    }
}
</script>
<style scoped>
.btn {
    width: 100%;
}

.main-card-title>.img {
    height: 30vh;
    border: 3px solid rosybrown;
    border-radius: 10px;
}

.main-card-title {
    background-color: whitesmoke;
    margin: 10px 20px;
    padding: 20px 0px;
}

th,
td {
    width: 20px;
}

.float-right {
    float: right;
}

.total {
    font-size: large;
    font-weight: 800;
}
</style>