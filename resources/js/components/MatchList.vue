<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Match</th>
                <th>Round</th>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Local</th>
                <th>Visitor</th>
                <th>Period</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(match, index) of matchDatas">
                <td>
                    {{match.name}}
                </td>
                <td>
                    {{match.round}}
                </td>
                <td>
                    {{match.type}}
                </td>
                <td>
                    {{match.date}}
                </td>
                <td>
                    {{match.time}}
                </td>
                <td>
                    {{match.localteam.name}}<br/>
                    Score: {{match.localteam.score}}
                </td>
                <td>
                    {{match.awayteam.name}}<br/>
                    Score: {{match.awayteam.score}}
                </td>
                <td>
                    <ul v-for="p of match.scoreboard">
                        <li>
                            <b>Period {{ p.period.name }}</b> : Local <b>({{p.period.localteam}})</b>, Visitor <b>({{p.period.visitorteam}})</b>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "MatchList",
    data() {
        return {
            matches: [],
            tokenConfig: '',
        }
    },
    mounted() {
        this.getToken();
        this.timer = setInterval(this.getAllMatches, 60000);
    },
    methods: {
        getToken() {
            this.axios.post('user/token').then((response) => {
                    this.tokenConfig = {
                        headers: { Authorization: `Bearer ${response.data.token}` }
                    };
                    this.getAllMatches();
                })
                .catch((e) => {
                    console.error(e);
                })
        },
        getAllMatches() {
            this.axios.get('matches', this.tokenConfig).then((response) => {
                this.matches = response.data;
            })
                .catch((e) => {
                    console.error(e);
                })
        },
        cancelAutoUpdate () {
            clearInterval(this.timer);
        }
    },
    computed: {
        matchDatas() {
            return this.matches.map((match) => {
                const tmp = JSON.parse(JSON.stringify(match));
                if (tmp.localteam) {
                    tmp.localteam = JSON.parse(tmp.localteam);
                }
                if (tmp.awayteam) {
                    tmp.awayteam = JSON.parse(tmp.awayteam);
                }
                if (tmp.scoreboard) {
                    tmp.scoreboard = JSON.parse(tmp.scoreboard);
                }
                console.log(tmp.scoreboard);
                return tmp;
            })
        },
    },
    beforeDestroy () {
        this.cancelAutoUpdate();
    }
}
</script>

<style scoped>

</style>
