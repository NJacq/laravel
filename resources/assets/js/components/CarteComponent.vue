<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep par département</div>

                    <div class="card-body">
                    <p>Vous êtes sur home.blade.php</p>

                    <l-map style="height: 400px" :zoom="zoom" :center="center">
                        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                        <l-geo-json v-if="show" :geojson="geojson" :options="options"></l-geo-json>
                        <l-marker :lat-lng="marker"></l-marker>
                    </l-map>
                    <router-link v-bind:to='"/departements"'>Liste des départements</router-link>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import { LMap, LTileLayer,  LGeoJson, LMarker } from 'vue2-leaflet';
    export default {
        name: 'Home',
        components: {
            LMap,
            LTileLayer,
            LGeoJson,
            LMarker
        },
        data () {
            return {
                show: true,
                zoom:5,
                center:[46.413220, 1.419482],
                geojson: null,
                options: {
                    style: function () {
                    return {
                        weight: 1,
                        color: '#003150',
                        opacity: 1,
                        fillColor: '#ffffff',
                        fillOpacity: 0.7                    
                    }
                }
            },
            url:'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            attribution:'&copy; <a href="http://osm.org/copyright">iOoOpenStreetMap</a> contributors',
            marker: L.latLng(47.413220, 0.219482),
            }
        },
        created () {
            axios.get("http://localhost:8000/api/departements/geojson").then(response => {
                this.geojson = response.data;
            });
        },
    }    
    function highlightFeature(e) {
        var layer = e.target;

        this.layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            this.layer.bringToFront();
        }
    }
    function resetHighlight(e) {
        this.geojson.resetStyle(e.target);
    }
</script>
<style scoped>
</style>