(function (blocks, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;

    blocks.registerBlockType(
        'photo-soushi-blocks/photo-caption-block',
        {
            title: 'Photo Caption',
            icon: 'camera',
            category: 'text',
            example: {},
            //photoCaption 属性を定義（入力された値を保存する変数）
            attributes: {
                photoCaption: {
                    type: 'string',
                    default: 'write photo caption here.'
                }
            },
        edit: function (props) {
            //onChange ハンドラ（コールバック関数）の定義
            function onChangeContent(newText) {
              //photoCaption の値を更新
              props.setAttributes({ photoCaption: newText });
            }
            return el(
              TextControl,
              {
                //onChange ハンドラ（コールバック関数）の指定
                onChange: onChangeContent,
                //photoCaption 属性の値を value プロパティに設定
                value: props.attributes.photoCaption,
                style: {
                  color: "gray",
                  fontSize: "75%",
                  textAlign: "right",
                  border: "solid 1px #f5f5f5"
                }
              }
            );
        },
           save: function (props) {
               // 表示はpタグで行い，classにはphoto-desc(style.cssで定義)を指定する
               return el(
                 'figcaption',
                 { className: "photo-desc" },
                 props.attributes.photoCaption
               );
           },
        }
  );
}(
  window.wp.blocks,
  window.wp.element,
  //テキスト入力のコンポーネント（TextControl）を使うので wp.components を追加
  window.wp.components
));