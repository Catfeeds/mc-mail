<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/5/8
 * Time: 15:56
 *
 *                                _oo8oo_
 *                               o8888888o
 *                               88" . "88
 *                               (| -_- |)
 *                               0\  =  /0
 *                             ___/'==='\___
 *                           .' \\|     |// '.
 *                          / \\|||  :  |||// \
 *                         / _||||| -:- |||||_ \
 *                        |   | \\\  -  /// |   |
 *                        | \_|  ''\---/''  |_/ |
 *                        \  .-\__  '-'  __/-.  /
 *                      ___'. .'  /--.--\  '. .'___
 *                   ."" '<  '.___\_<|>_/___.'  >' "".
 *                  | | :  `- \`.:`\ _ /`:.`/ -`  : | |
 *                  \  \ `-.   \_ __\ /__ _/   .-` /  /
 *              =====`-.____`.___ \_____/ ___.`____.-`=====
 *                                `=---=`
 *
 *
 *             ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *                         佛祖保佑    永无BUG
 *
 */

namespace App\Admin\Controllers\Orders;


use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;

/**
 * @module 评论管理
 *
 * Class CommentController
 * @package App\Admin\Controllers\Orders
 */
class CommentController extends Controller
{
    /**
     * @permission 评论列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $comments = Comment::paginate(10);

        return view('admin::orders.comments', compact('comments'));
    }

    /**
     * @permission 查看评论
     *
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Comment $comment)
    {
        if ($comment->read == Comment::UNREAD) {
            $comment->read = Comment::READ;
            $comment->save();
        }

        return view('admin::orders.comment-show', compact('comment'));
    }

    /**
     * @permission 回复评论
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $message = $request->get('message');
        $reply = new CommentReply(['message' => $message]);
        $comment->reply()->save($reply);

        return response()->json(['status' => 1, 'message']);
    }

    /**
     * @permission 删除评论
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        $comment->reply()->delete();

        return response()->json(['status' => 1, 'message' => '删除成功']);
    }
}