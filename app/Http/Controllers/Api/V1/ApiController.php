<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Package;
use App\Payment;
use App\Test;
use App\User;
use Illuminate\Http\Response;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\ActiveTest as ActiveTestResource;
use App\Http\Resources\Test as TestResource;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PackageDetail as PackageDetailResource;
use App\Http\Resources\Package as PackageResource;


use App\Http\Resources\UserTest as UserTestResource;

class ApiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/v1/all-user",
     *      operationId="getUserList",
     *      tags={"Users"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function allUsers()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'users' => UserResource::collection($users)
            ],

            'message' => 'All users pulled out successfully'

        ]);
    }

    /**
     * @OA\Post(
     *      path="/v1/test",
     *      operationId="getActiveTestList",
     *      tags={"Tests"},

     *      summary="Get list of active tests",
     *      description="Returns list of active tests",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function getActiveTest()
    {
        $tests = Test::where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'test' => ActiveTestResource::collection($tests)
            ],

            'message' => 'Active tests pulled out successfully'
        ]);
    }

    /**
     * @OA\Post(
     ** path="/v1/testdetail/{id}",
     *   tags={"Tests"},
     *   summary="Test Detail",
     *   operationId="testdetails",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function testDetails($id)
    {
        $test = Test::with('testSections', 'testSections.questions')->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'test' => new TestResource($test)
            ],

            'message' => 'Test detail pulled out successfully'
        ]);
    }

    /**
     * @OA\Post(
     ** path="/v1/paymentdetail/{id}",
     *   tags={"Payments"},
     *   summary="Payment Detail",
     *   operationId="paymentdetails",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function paymentDetail($id)
    {
        $paymentDetail = Payment::where('user_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'paymentDetail' => PaymentResource::collection($paymentDetail)
            ],

            'message' => 'Payment detail of the user pulled out successfully'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/v1/package",
     *      operationId="getPackageList",
     *      tags={"Packages"},

     *      summary="Get list of Packages",
     *      description="Returns list of packages",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function getPackages()
    {
        $packages = Package::where('status', 1)->get();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'active packages' => PackageResource::collection($packages)
            ],

            'message' => 'All active packages pulled out successfully'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/v1/packagedetail/{id}",
     *      operationId="getPackageDetail",
     *      tags={"Packages"},
     *      summary="Get list of Packages detail",
     *      description="Returns list of packages detail",
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function getPackageDetails(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'test package detail' => new PackageDetailResource($package)
            ],

            'message' => 'Test list within the package pulled out successfully'
        ]);
    }

    /**
     * @OA\Post(
     *      path="/v1/testuser",
     *      operationId="getTestUserList",
     *      tags={"Users"},

     *      summary="Get list of Test users",
     *      description="Returns list of test Users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function testUsers()
    {
        $user = User::findOrFail(3);

        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'test' => UserTestResource::collection($user->testUser)
            ],

            'message' => 'Test users\' detail pulled out successfully'
        ]);
    }
}