<script setup>
import axios from "axios";
import { ref } from "vue";

const response = ref();
const responseWeather = ref();

const getPlace = async (value) => {
    try {
        await getWeather(value);
        response.value = await axios.get("/api/place", {
            params: {
                data: { near: value }
            }
        });
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
};

const getWeather = async (value) => {
    try {
        responseWeather.value = await axios.get("/api/weather", {
            params: {
                data: { q: value }
            }
        });
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
};
</script>

<template>
    <div>
        <h1 class="text-center my-4">Welcome to Weather Forecast</h1>
        <div class="text-center table-responsive">
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Tokyo,JP')">Tokyo</b-button>
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Yokohama,JP')">Yokohama</b-button>
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Kyoto,JP')">Kyoto</b-button>
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Osaka,JP')">Osaka</b-button>
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Sapporo,JP')">Sapporo</b-button>
            <b-button class="mx-1 mt-3" @click.prevent="getPlace('Nagoya,JP')">Nagoya</b-button>
        </div>

        <div class="center-div mt-3 col-11 card-container" v-if="responseWeather">
            <div class="card float-start p-2 m-2" v-for="(weather, i) in responseWeather.data.list" :key="i">
                <div class="fw-semibold">{{ weather.dt_txt }}</div>
                <div class="fw-semibold text-capitalize">{{ weather.weather[0].description }}</div>
                <div class="weather-icon">
                    <img :src="'https://openweathermap.org/img/w/' + weather.weather[0].icon + '.png'" />
                </div>
                <div>Temp: {{ weather.main.temp }}°C</div>
                <div>Wind: {{ weather.wind.speed }}</div>
                <div>Gust: {{ weather.wind.gust }}</div>
            </div>
        </div>

        <div style="clear:both" class="mt-5 col-10 center-div accordion accordion-flush" v-if="response" id="accordionExample">
            <div class="pt-5"><h1 class="text-center">Places to visit</h1></div>
                <div class="accordion-item" v-for="(place, i) in response.data.results" :key="i">
                    <h2 class="accordion-header" :id="'heading' + i">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse' + i" aria-expanded="false" :aria-controls="'collapse' + i">
                            <div class="accordion-body">
                            <div class="fw-bold">{{ place.name }}</div>
                            <div class="ms-2">
                                <img style="float:left" :src="place.categories[0].icon.prefix + '44' + place.categories[0].icon.suffix" />
                                {{ place.categories.map(p => p.name).join('/') }}
                            </div>
                        </div>
                        </button>
                    </h2>
                    <div :id="'collapse' + i" class="accordion-collapse collapse" :aria-labelledby="'heading' + i" data-bs-parent="#accordionExample">
                        <div class="m-4 ms-5">{{ place.location.formatted_address }}</div>
                    </div>
                </div>
            </div>
        </div>
</template>
