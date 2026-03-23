# 環境構築手順

## <1>.env作成
* .env-exampleをコピーして、ファイル名を「.env」に変更する
<br><br>
* Macユーザーの場合、「docker-compose.override.yml-example」をコピーして、ファイル名を「docker-compose.override.yml」に変更する
<br><br>

## <2>コンテナ起動
* ターミナルを開き、「docker-compose up -d」を実行する
<br><br>

## <3>コンテナ起動確認
* localhost:8000/wp-dir(サブディレクトリ)にアクセスして、WordPressインストール画面が表示されることを確認(操作は不要)<br>
(http://localhost:8000/wp-dir)<br>
※ポート番号は環境に応じて変更
<br><br>

## <4>コンテナに入る
* ターミナルにて、「docker-compose exec {コンテナ名(app 等)} bash」を実行する<br>
* /var/www/resources/htdocs/wp-dir(サブディレクトリ)にいることを確認
<br><br>

## <5>Wordpressのインストール用スクリプトの実行
* <4>でコンテナに入った状態で、「bash ../wp-install.sh」を実行する
<br><br>

## <6>Wordpressがインストール完了の確認
* localhost:8000にアクセスして、画面が表示されることを確認する<br>
* localhost:8000/wp-dir/wp-login.php/にアクセスして、ログイン画面が表示されることを確認<br>
(データベースの更新が必要です　と表示される場合は、そのままボタンを押下して進む)<br>
※ポート番号は環境に応じて変更
<br><br>

## <7>ログイン確認
wp-install.shに書かれたユーザー名・パスワードでログインできることを確認する<br>
adminUser (ユーザ名)<br>
adminPass (パスワード)
