function kaomoji(options = {
    cheecks: ["()", "{}", "⟨⟩"],
    cheeckbones: ["oo", "｡｡", "っς", "〃〃", "๑๑", "„„", ["", ""]],
    eyes: ["^^", "◕◕", "´`", "≧≦", "⌒⌒", "￣￣", "・・", "••", "°°", "＾＾", "･･", "¯¯", "˘˘", "▔▔", "──", "✯✯", "☆☆", "≧≦", "⌒⌒", "✧✧", "><", "￢￢"],
    noses: ["ω", "∀", "‿", "▽", "︶", "ᗢ", "‿‿", "◡", "ヮ", "ᴗ", "֊"]
}) {
    const cheeck = rand(options.cheecks)
    const cheeckbone = rand(options.cheeckbones)
    const eye = rand(options.eyes)
    const nose = rand(options.noses)
    return `${cheeck[0]}${cheeckbone[0]}${eye[0]}${nose}${eye[1]}${cheeckbone[1]}${cheeck[1]}`
}
function rand(array) {
    return array[Math.floor(Math.random() * array.length)]
}