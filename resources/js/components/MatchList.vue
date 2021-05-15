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
                    {{match.localteam.team_name}} ({{match.localteam.player}}) <br/>
                    Score: {{match.localteam.score}}
                </td>
                <td>
                    {{match.visitorteam.team_name}} ({{match.visitorteam.player}}) <br/>
                    Score: {{match.visitorteam.score}}
                </td>
                <td>
                    <ul v-for="p of match.period_score">
                        <li>
                            <b>{{ p.period }}</b> : Local <b>({{p.localscore}})</b>, Visitor <b>({{p.visitorscore}})</b>
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
        this.registerUser();
        this.timer = setInterval(this.getAllMatches, 60000);
    },
    methods: {
        registerUser() {
            this.axios.post('http://localhost:8000/api/user/register', {
                name: "testAPI12345",
                email: "testAPI12345@mail.com",
                password: "testAPI123456",
                password_confirmation: "testAPI123456"
            }).then((response) => {
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
            this.axios.get('http://localhost:8000/api/matches', this.tokenConfig).then((response) => {
                this.matches = response.data;
            })
                .catch((e) => {
                    console.error(e);
                })
        },
        removeDuplicate(arr, key) {
            return arr.filter((v,i,a) => a.findIndex(t => (t[key] === v[key])) === i);
        },
        cancelAutoUpdate () {
            clearInterval(this.timer);
        }
    },
    computed: {
        matchDatas() {
            return this.matches.map((match) => {
                if (match.period_score) {
                    match.period_score = this.removeDuplicate(JSON.parse(match.period_score), 'period');
                } else {
                    match.period_score = [];
                }
                if (match.teams_vs) {
                    match.teams_vs = this.removeDuplicate(JSON.parse(match.teams_vs), 'team_name');
                    match.localteam = match.teams_vs.filter(item => item.type === 'localteam')[0];
                    match.visitorteam = match.teams_vs.filter(item => item.type === 'awayteam')[0];
                }
                console.log(match)
                return match;
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
