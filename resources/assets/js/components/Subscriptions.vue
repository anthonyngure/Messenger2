<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-tabs fixed-tabs
                    dark
                    v-model="currentItem"
                    color="primary"
                    grow>
                <v-tab v-for="(subscriptionType, index) in subscriptionTypes"
                       :key="index"
                       :href="`#${subscriptionType.name}`">
                    {{subscriptionType.name}}
                </v-tab>
            </v-tabs>
            <v-data-table
                    :headers="headers"
                    :items="subscriptionItems"
                    hide-actions
                    class="elevation-2">
                <template slot="items" slot-scope="props">
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-center">{{ props.item.clientSubscription ? props.item.clientSubscription.quantity
                        : 0 }}
                    </td>
                    <td class="text-xs-center">{{ props.item.clientSubscription ?
                        props.item.clientSubscription.createdAt
                        : 'N/A' }}
                    </td>
                    <td class="text-xs-center">{{ props.item.clientSubscription ? 0
                        : 0 }}
                    </td>
                    <td class="text-xs-center">KES. {{ props.item.clientSubscription ? 0
                        : 0 }}
                    </td>
                    <td class="text-xs-center">
                        <v-btn small outline color="red"
                               v-if="props.item.clientSubscription">Unsubscribe
                        </v-btn>
                        <v-btn @click.native="subscribeItem = props.item" small outline color="primary" v-else>
                            Subscribe
                        </v-btn>
                    </td>
                </template>
            </v-data-table>
        </v-flex>
        <v-flex xs12>
            <subscription-dialog :subscribeItem="subscribeItem"
                                 @onClose="onCloseSubscriptionDialog"
                                 :subscriptionSchedules="subscriptionSchedules">
            </subscription-dialog>
        </v-flex>
    </v-layout>
</template>

<script>
	import SubscriptionDialog from './SubscriptionDialog'

	export default {
		components: {SubscriptionDialog},
		name: 'subscriptions',
		data () {
			return {
				connecting: false,
				currentItem: null,
				subscribeItem: null,
				subscriptionTypes: [],
				subscriptionItems: [],
				subscriptionSchedules: [],
				headers: [
					{
						text: 'Name',
						align: 'left',
						sortable: false,
						value: 'name'
					},
					{text: 'Quantity Subscribed', sortable: false, value: ''},
					{text: 'Subscription Date', sortable: false, value: ''},
					{text: 'Total Deliveries', sortable: false, value: ''},
					{text: 'Total Cost', sortable: false, value: ''},
					{text: 'Subscription', sortable: false, value: ''},
				],

			}
		},
		watch: {
			currentItem (currentItem) {
				this.$utils.log(currentItem)
				if (currentItem && !this.connecting) {
					let subscriptionType = this.subscriptionTypes.find(function (element) {
						return element.name === currentItem
					})
					this.subscriptionItems = subscriptionType.subscriptionItems
				}
			},
			subscribeItem (subscribeItem) {
				this.dialog = !!subscribeItem
			},
			everydayCheckbox (everydayCheckbox) {
				if (everydayCheckbox) {
					for (let weekday of this.weekdays) {
						weekday.selected = false
					}
				}
			},
			weekdays (weekdays) {
				this.$utils.log(weekdays)
				let selected = 0
				for (let weekday of weekdays) {
					if (weekday.selected) {
						selected = selected + 1
					}
				}
				if (selected === 5) {
					this.everydayCheckbox = true
				}
			}
		},
		methods: {
			loadSubscriptions () {
				this.connecting = true
				this.axios.get('/subscriptions').then(response => {
					this.connecting = false
					this.$utils.log(response)
					this.subscriptionTypes = []
					for (let item of response.data.data.subscriptionTypes) {
						this.subscriptionTypes.push(item)
					}
					this.subscriptionSchedules = response.data.data.subscriptionSchedules
					this.currentItem = this.subscriptionTypes[0].name
				}).catch(error => {
					this.connecting = false
				})
			},
			onCloseSubscriptionDialog (subscriptionItem) {
				if (subscriptionItem) {
					let updatedSubscriptionItem = this.subscriptionItems.find(function (element) {
						return element.id === subscriptionItem.id
					})
					this.$utils.log('Updated Item....')
					this.$utils.log(updatedSubscriptionItem)
					let updatedIndex = this.subscriptionItems.indexOf(updatedSubscriptionItem)
					this.$utils.log('Index ' + updatedIndex)
					let tempSubscriptionItems = this.subscriptionItems
					tempSubscriptionItems[updatedIndex] = subscriptionItem
					this.subscriptionItems = []
					for (let item of tempSubscriptionItems) {
						this.subscriptionItems.push(item)
					}
				}
				this.subscribeItem = null
			}
		},
		mounted () {
			this.loadSubscriptions()
		}
	}
</script>

<style scoped>

</style>