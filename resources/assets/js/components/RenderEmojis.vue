<script>
import { Emoji } from 'emoji-mart-vue'

function renderEmoji(h, emoji, size) {
  return h(Emoji, {
    props: { emoji: emoji, size: size }
  })
}

function renderEmojis(h, val, size) {
  let match = null
  let emojis = []
  const EMOJI_REGEX = /:[^:\s]*[^:\s]:/g
  while (match = EMOJI_REGEX.exec(val)) {
    emojis.push({
      el: renderEmoji(h, match[0], size),
      from: match.index,
      to: match.index + match[0].length
    })
  }

  return emojis
}
export default {
	props: {
	    message: {
	        type: String,
	        required: true
	   	},
	   	truncate: {
	   		default:false,
	   		type: Boolean
	   	},
	   	size: {
	   		type:Number,
	   		default: 24
	   	}
	},
	components: { Emoji },
	render (h) {
		let index = 0
		let children = []
		let emojis = renderEmojis(h, this.message,this.size)

		for (let emoji of emojis) {
		  children.push(this.message.slice(index, emoji.from))
		  children.push(emoji.el)

		  index = emoji.to
		}

		children.push(this.message.slice(index))

		let str_length = 0
		if(this.truncate){
			for (var i = 0; i < children.length; i++) {
				//find emojis
				if(children[i] !== null && typeof children[i] === 'object'){
					// each emoji count as 2 chars
					str_length += 2
					if(str_length >= 18) {
						//truncate string
						for (var x = i; x < children.length; x++) {
							children.splice(x, 1)
						}

						//Append tree dots.
						children[i+1] = '...' 
						break
					}
				}else if(children[i] !== null && typeof children[i] === 'string') {
					str_length += children[i].length
					if(str_length >= 18) {
						//truncate string
						children[i] = children[i].substring(0, 18)

						//Append tree dots.
						children[i+1] = '...' 
						break
					}
				}
			}
		}
		return h('p', {}, children)
	}
}
</script>