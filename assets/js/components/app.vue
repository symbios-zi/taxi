<style scoped>
    .journey-info__submit {
        margin-top: 20px;
        display: block;
    }
</style>

<template>
    <div class="row">
        <div class="col-4 offset-md-2">
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
        <div class="col-4">
            <div class="card journey-info__container">
                <div class="card-body">
                    <h5 class="card-title text-center">Ваша поездка:</h5>
                    <div class="text">
                        <span class="title">Стоимость: </span>
                        <span>{{ journeyInfo.price | roubleCurrency }}</span>
                    </div>
                    <div class="text">
                        <span class="title">Растояние: </span>
                        <span>{{ journeyInfo.distance | kilometerFormat }} км</span>
                    </div>
                    <div class="text">
                        <span class="title">Примерное время: </span>
                        <span>{{ journeyInfo.duration | timeFormat }} </span>
                    </div>
                    <div class="text">
                        <button
                            class="journey-info__submit btn btn-primary mx-auto"
                            v-on:click="orderJourney"
                        >Заказать</button>
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
                },
                journeyInfo: {}
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
                let self = this;
                const data = new FormData();
                data.append('from', route.from);
                data.append('to', route.to);

                axios.post('/journey', data)
                    .then(function (response) {
                        self.journeyInfo = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            orderJourney() {
                let self = this;
                const data = new FormData();
                data.append('from', this.route.from);
                data.append('to', this.route.to);

                axios.post('/journey/order', data)
                    .then(function (response) {
                        self.orderResult = response.data;
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