<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Property</th>
                                    <th>Photo</th>
                                    <th>Address</th>
                                    <th>Desc</th>
                                    <th>Rents</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Days</th>
                                    <th>Paid Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Property</th>
                                    <th>Photo</th>
                                    <th>Address</th>
                                    <th>Desc</th>
                                    <th>Rents</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Days</th>
                                    <th>Paid Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr v-for="(property, index) in properties" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ property.title }}</td>
                                    <td><img class="min-image" :src="'/images/' + property.photo" /> </td>
                                    <td>{{ property.Address }}</td>
                                    <td>{{ property.Desc }}</td>
                                    <td>&#8377;{{ property.price }}</td>
                                    <td>{{ property.start_date }}</td>
                                    <td>{{ property.end_date }}</td>
                                    <td >{{ countDays(property.start_date,property.end_date) }}</td>
                                    <td >&#8377;{{ countTotalRent(countDays(property.start_date,property.end_date),property.price) }}</td>
                                </tr>
                            </tbody>
                        </table>
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
            api: 'http://127.0.0.1:8000/api/history',
            days: null,
            paid: null
        }
    },
    mounted() {
        // get API data
        this.axios.get(this.api).then(res => {
            this.properties = res.data;
            var date1 = new Date(this.checkInDate);
            var date2 = new Date(this.checkOutDate);
            var Difference_In_Time = date2.getTime() - date1.getTime();
            this.Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
        }).catch(error => {

        })
    },
    methods:{
        countDays(start_date,end_date){
            var date1 = new Date(start_date);
            var date2 = new Date(end_date);
            var Difference_In_Time = date2.getTime() - date1.getTime();
            return Difference_In_Time / (1000 * 3600 * 24);
        },
        countTotalRent(totalDays,rent){
            return totalDays*rent;
        }
    }
}
</script>
