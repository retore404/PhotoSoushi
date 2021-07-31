# WordPressテーマ "PhotoSoushi"

[![WordPress Theme Code Check](https://github.com/retore404/PhotoSoushi/actions/workflows/workflow.yml/badge.svg)](https://github.com/retore404/PhotoSoushi/actions/workflows/workflow.yml)

![WordPressテーマ"PhotoSoushi"](https://github.com/retore404/PhotoSoushi/blob/images/single_pc.png)

## 概要

写真×雑記のブログでの使用を意図したWordPressテーマ．

最新版の使用例は [こちら(https://photo.retore.jp/)](https://photo.retore.jp/)

## 対応ブラウザ

- Gridレイアウトに対応するブラウザ

## 特徴

### 1. 写真×文章に最適なレイアウト・機能

#### 1-1. 写真・文章をどちらも見やすく配置するレイアウト

![写真・文章をどちらも見やすく配置するレイアウト](https://github.com/retore404/PhotoSoushi/blob/images/single_pc_bleed.png)

「写真は大きく表示したいが，写真に合わせて記事の表示部分の横幅が長くなると文章が読みにくい」という課題を解決するため，フルブリードレイアウトの考え方を取り入れたレイアウトを採用．

写真はグリッド内の横幅を目一杯使う一方，文章部は1行あたりの文字数が増えすぎないレイアウト．

写真と文章部で横幅を変えることで「写真は大きく」「文章は読みやすい」を両立．

#### 1-2. カメラ関連のタグ名の置き換え機能

記事中の写真の撮影機材（レンズ）・撮影場所をタグとして持つことを想定し，タグ名に含まれる"Canmera:"，"Lens:"および"Location:"をアイコンに置き換える機能を持つ．  
また，タグ名に含まれる「T*」は赤字で表示される．

| 置き換え対象 | 表示例 |
|:---|:---:|
| "Camera:" | !["Camera:"の置き換え](https://github.com/retore404/PhotoSoushi/blob/images/tag_camera.png) |
| "Lens:"/T* | !["Lens:"の置き換え](https://github.com/retore404/PhotoSoushi/blob/images/tag_lens.png) |
| "Location:" | !["Location:"の置き換え](https://github.com/retore404/PhotoSoushi/blob/images/tag_location.png) |


#### 1-3. 3:2/16:9/シネスコ画像に対応する一覧画面

記事一覧画面のアイキャッチ画像表示部は3:2固定としつつ，背景色を黒色として画像を中央に配置する実装．16:9画像やシネスコ画像も違和感なく一覧画面のアイキャッチとして表示することができる．

- 表示例：左の画像は3:2，右の画像は16:9

![アイキャッチ画像の表示](https://github.com/retore404/PhotoSoushi/blob/images/index_eyecatch.png)

### 2. Gridレイアウトを用いたレスポンシブ対応

Gridレイアウトを採用することでレスポンシブ対応を実現．

| 表示デバイス | 表示例 |
|:---|:---:|
| PC | ![PCで表示した例](https://github.com/retore404/PhotoSoushi/blob/images/index_pc_responsive.png) |
| タブレット | ![タブレットで表示した例](https://github.com/retore404/PhotoSoushi/blob/images/index_tab_responsive.png) |
| スマホ | ![スマホで表示した例](https://github.com/retore404/PhotoSoushi/blob/images/index_sp_responsive.png) |


## 詳細

- 対応画像フォーマット：WordPress標準でサポートする形式に加え，WebP形式をサポート．

## バージョン管理

ver5.0.0以降のバージョン管理において，セマンティック・バージョニングを援用する．

ただし，APIを持たないWordPressテーマであることから，メジャーバージョンについてはテーマの方式に関わる大きな変更の場合にバージョンアップすることとする．

## 使用方法

- [リリースページ](https://github.com/retore404/PhotoSoushi/releases) より最新のリリースをダウンロードし，WordPressの指定のフォルダに解凍する

もしくは

- 本リポジトリのmasterブランチをcloneする

## ライセンス

WordPress本体のライセンスに従いGPLとする．