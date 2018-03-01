<?php
	
	namespace App\Http\Controllers;
	
	use App\ClientSubscription;
	use App\ClientSubscriptionSchedule;
	use App\LogHelper;
	use App\Subscription;
	use App\SubscriptionItem;
	use App\SubscriptionSchedule;
	use App\SubscriptionType;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	use Illuminate\Http\Request;
	
	class SubscriptionController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 * @throws \App\Exceptions\WrappedException
		 */
		public function index()
		{
			$client = $this->getClient();
			
			$subscriptionTypes = SubscriptionType::with(['subscriptionItems' => function (HasMany $hasMany) use ($client) {
				$hasMany->with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
					$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
				}]);
			}])->get();
			
			$subscriptionSchedules = SubscriptionSchedule::all();
			
			$data = [
				'subscriptionTypes'     => $subscriptionTypes,
				'subscriptionSchedules' => $subscriptionSchedules,
			];
			
			return $this->arrayResponse($data);
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create()
		{
			//
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 * @throws \Illuminate\Validation\ValidationException
		 * @throws \App\Exceptions\WrappedException
		 */
		public function store(Request $request)
		{
			//
			\Validator::validate($request->json()->all(), [
				'subscriptionItemId' => 'required|exists:subscription_items,id',
				'quantity'           => 'required|numeric',
				'schedules'          => 'required',
			]);
			
			LogHelper::info($request, "Add Client Subscription");
			
			$client = $this->getClient();
			$clientSubscription = ClientSubscription::firstOrCreate([
				'client_id'            => $client->getKey(),
				'quantity'             => $request->json('quantity'),
				'subscription_item_id' => $request->json('subscriptionItemId'),
			]);
			
			$schedules = $request->json('schedules');
			foreach ($schedules as $schedule) {
				ClientSubscriptionSchedule::firstOrCreate([
					'client_subscription_id'   => $clientSubscription->getKey(),
					'subscription_schedule_id' => $schedule,
				]);
			}
			
			$subscription = SubscriptionItem::with(['clientSubscription' => function (HasOne $hasOne) use ($client) {
				$hasOne->where('client_id', $client->getKey())->with('subscriptionSchedules');
			}])->findOrFail($request->json('subscriptionItemId'));
			
			return $this->itemCreatedResponse($subscription);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
