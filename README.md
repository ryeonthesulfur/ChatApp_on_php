+ # chat-app データベース設計
 

## テーブル定義

### `users`

アソシエーション
hasMany: users (through room_users)
hasMany: messages 

| カラム名    | 型       | NULL | Key | 備考            |
| :--------- | :------- | :--- | :-- | :------------- |
| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
| name       | string   | NO   |     |                |
| email      | string   | NO   |     | UNIQUE         |
| password   | string   | NO   |     |                |
| created_at | datetime | NO   |     |                |
| updated_at | datetime | NO   |     |                |



### `rooms`

| カラム名    | 型       | NULL | Key | 備考            |
| :--------- | :------- | :--- | :-- | :------------- |
| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
| name       | string   | NO   |     |                |
| created_at | datetime | NO   |     |                |
| updated_at | datetime | NO   |     |                |




### `room_users` (中間テーブル)

 アソシエーション
 hasMany: rooms
 hasMany: users

| カラム名    | 型       | NULL | Key | 備考             |
| :--------- | :------- | :--- | :-- | :------------- |
| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
| room_id    | bigint   | NO   | FK  | `rooms.id`     |
| user_id    | bigint   | NO   | FK  | `users.id`     |
| created_at | datetime | NO   |     |                |
| updated_at | datetime | NO   |     |                |

 

### `messages`

| カラム名     | 型       | NULL | Key | 備考                               |
| :--------- | :------- | :--- | :-- | :--------------------------------- |
| id         | bigint   | NO   | PK  | AUTO_INCREMENT                     |
| content    | text     | YES  |     |                                    |
| image      | string   | YES  |     | アップロードされた画像ファイルのパス     |
| user_id    | bigint   | NO   | FK  | `users.id`                         |
| room_id    | bigint   | NO   | FK  | `rooms.id`                         |
| created_at | datetime | NO   |     |                                    |
| updated_at | datetime | NO   |     |                                    |



## アソシエーション (Eloquent)

 アソシエーション
 hasMany: users
 hasMany: rooms

| モデル   | アソシエーション    | 関連先モデル   | 経由テーブル   | 備考                                 |
| :------ | :--------------- | :----------- | :----------- | :-----------------------------------|
| User    | `belongsToMany`  | Room         | `room_users` | ユーザーは複数のルームに所属する          |
| User    | `hasMany`        | Message      | -            | ユーザーは多数のメッセージを投稿する       |
| Room    | `belongsToMany`  | User         | `room_users` | ルームには複数のユーザーが参加する         | 
| Room    | `hasMany`        | Message      | -            | ルームには多数のメッセージが含まれる       |
| Message | `belongsTo`      | User         | -            | メッセージは1人のユーザーによって投稿される |
| Message | `belongsTo`      | Room         | -            | メッセージは1つのルームに投稿される        |




## 補足

*   **画像ファイルの保存**: `storage/app/public` ディレクトリに保存し、`image` カラムにはそのディレクトリからの相対パスを格納することを想定しています。
