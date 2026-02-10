const mottos = $$(".mottoContainer > div")
mottos.forEach((e) => {
  e.addEventListener("mouseover", () => {
    $$(".mottoTitle").forEach((el) => {
      el.style.opacity = 0
    })
    mottos.forEach((e2) => {
      e2.style.backgroundImage = `url(./images/${e.className}.jpg)`
    })
    $(`.des${e.className.replace(/[^0-9]/g, "")}`).style.opacity = 1
    e.querySelector(".mottoTitle").style.opacity = 1
  })

  e.addEventListener("mouseleave", () => {
    $$(".mottoTitle").forEach((el) => {
      el.style.opacity = 1
    })
    mottos.forEach((e2) => {
      e2.style.backgroundImage = `url(./images/${e2.className}.jpg)`
    })
    $(`.des${e.className.replace(/[^0-9]/g, "")}`).style.opacity = 0
  })
})
