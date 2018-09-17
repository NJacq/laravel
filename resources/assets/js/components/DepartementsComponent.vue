<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Stats arcep</div>

                    <div class="card-body">
                          <div id="loadingIndicatorCtn">
	                        <div class="fa-3x loadingIndicator">
                                <i class="fas fa-sync fa-spin"></i>
                            </div>
	                    </div>
                        <ul>
                            <li v-bind:key="departement.id" v-for="departement in departements">
                                <router-link class="" v-bind:to="`/departement/${departement.id}`">{{departement.nom_departement}}</router-link> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'Departements',
        data () {
            return {
                departements: {}
            }
        },
        created () {
            axios.get('http://localhost:8000/api/departements')
            .then(response => {
                console.log(response)
                this.departements = response.data
                // this.comp = JSON.parse(response.data)
                document.getElementById("loadingIndicatorCtn").style.display = 'none';
            })
            .catch(Err => {
                // console.log(err)
            })
        }
    }
</script>
