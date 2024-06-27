<script setup>
import axios from "axios";
import { ref } from "vue";

const response = ref();
const responseWeather = ref();
const buttons = ref([
  { isPressed: '', place: 'Tokyo', placeValue: 'Tokyo,JP' },
  { isPressed: '', place: 'Yokohama', placeValue: 'Yokohama,JP'  },
  { isPressed: '', place: 'Kyoto', placeValue: 'Kyoto,JP'  },
  { isPressed: '', place: 'Osaka', placeValue: 'Osaka,JP'  },
  { isPressed: '', place: 'Sapporo', placeValue: 'Sapporo,JP'  },
  { isPressed: '', place: 'Nagoya', placeValue: 'Nagoya,JP'  },
]);

const getPlace = async (value, place, index) => {
    // console.log(place);
    // selectedPlace = place;
    buttons.value.forEach((button, idx) => {
        button.isPressed = idx === index ? 'active' : '';
    });
    try {
        await getWeather(value);
        response.value = await axios.get("/api/place", {
            params: {
                data: { near: value }
            }
        });
        response.value.selectedPlace = place;
    } catch (error) {
        // Do something with the error
        console.log(error);
    }
// console.log(response.selectedPlace);
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
            <b-button
                v-for="(button, index) in buttons"
                variant="primary" 
                :key="index"
                @click="getPlace(button.placeValue, button.place, index)"
                :class="button.isPressed + ' mx-1 mt-3'"
            >
                {{ button.place }}
            </b-button>
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
            <div class="pt-5"><h1 class="text-center">Places to visit in {{ response.selectedPlace }}</h1></div>
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
