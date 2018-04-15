<template>
    <div class="row">
        <div class="col-4 offset-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Заказ такси</h5>
                    <div class="form-group">
                        <autocomplete
                            url="/api/v1/places/autocomplete"
                            anchor="description"
                            label="description"
                            name="point"
                            :classes="{ input: 'form-control', wrapper: 'input-wrapper'}"
                            :process="processJSON"
                            :onSelect="handleSelectFrom"
                            :placeholder="'Укажите адрес отправки'"
                        >
                        </autocomplete>
                    </div>
                    <div class="form-group">
                        <autocomplete
                            url="/api/v1/places/autocomplete"
                            anchor="description"
                            label="description"
                            name="destination"
                            :classes="{ input: 'form-control', wrapper: 'input-wrapper'}"
                            :process="processJSON"
                            :onSelect="handleSelectTo"
                            :placeholder="'Укажите адрес поездки'"
                        >
                        </autocomplete>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Autocomplete from 'vue2-autocomplete-js';
    import axios from 'axios';
    require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css');

    export default {
        components: { Autocomplete },
        data () {
            return {
                route: {
                    from: null,
                    to: null
                }
            }
        },
        methods: {
            processJSON(json) {
                return json.predictions;
            },
            handleSelectFrom({place_id}) {
                this.route.from = place_id
            },
            handleSelectTo({place_id}) {
                this.route.to = place_id
            },
            requestJourneyInformation(route) {

                const data = new FormData();
                data.append('from', route.from);
                data.append('to', route.to);

                axios.post('/journey', data)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        watch: {
            route: {
                handler: function (route) {
                    this.requestJourneyInformation(route);
                },
                deep: true
            }
        }
    };
</script>