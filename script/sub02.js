// 영상제어
const video = $("video");
const controls = $(".controls");
const controlsContainer = $(".controls-container");

let isAuto = localStorage.getItem("auto") === "true";

if (isAuto) {
  video.muted = true;
  video.play();
}

controlsContainer.addEventListener("click", (e) => {
  const t = e.target.classList;

  if (t.contains("ctrl01")) video.play();
  if (t.contains("ctrl02")) video.pause();
  if (t.contains("ctrl03")) {
    video.pause();
    video.currentTime = 0;
  }
  // 건너뛰기 및 돌아가기
  if (t.contains("ctrl04")) video.currentTime -= 10;
  if (t.contains("ctrl05")) video.currentTime += 10;
  // 재생속도
  if (t.contains("ctrl06"))
    video.playbackRate = Math.max(0.1, video.playbackRate - 0.1);
  if (t.contains("ctrl07")) video.playbackRate += 0.1;
  if (t.contains("ctrl08")) video.playbackRate = 1;
  if (t.contains("ctrl09")) video.loop = !video.loop;
  if (t.contains("ctrl10")) {
    isAuto = !isAuto;
    localStorage.setItem("auto", isAuto);
    video.muted = isAuto;
    isAuto ? video.play() : video.pause();
  }
  if (t.contains("ctrl11")) {
    controls.style.display =
      controls.style.display === "none" ? "block" : "none";
  }
});

//드래그앤 드롭
const userId = $(".userId");
const modal = $(".non-user-bg");
const drop = $(".drop");
const IDS = "qazwsxedcrfvtgbyhunjimklp1234567890".split("");

$(".open").onclick = () => {
  document.body.style.overflow = "hidden";
  modal.style.display = "flex";
};
// 닫기버튼
$(".close").onclick = closeModal;

function closeModal() {
  document.body.style.overflowY = "scroll";
  modal.style.display = "none";
}
// 랜덤 아이디 생성
userId.textContent += Array.from(
  { length: 6 },
  () => IDS[Math.floor(Math.random() * IDS.length)],
).join("");
// 드래그
function giveDrag() {
  $$(".non-user-container .product-container .item").forEach((item) => {
    item.draggable = true;
    item.ondragstart = (e) => {
      e.dataTransfer.setData("html", item.innerHTML);
      e.dataTransfer.setData("id", item.querySelector("img").alt);
    };
  });
}
// 드롭
drop.ondragover = (e) => e.preventDefault();

drop.ondrop = (e) => {
  const html = e.dataTransfer.getData("html");
  const id = e.dataTransfer.getData("id");

  const origin = $(`.non-user-container .item:has(img[alt="${id}"])`);
  if (origin) origin.style.opacity = 0.5;

  const exist = drop.querySelector(`img[alt="${id}"]`);
  if (exist) {
    const input = exist.closest(".item").querySelector("input");
    input.value = +input.value + 1;
    priceChange();
    return;
  }
  // 푸터
  const item = document.createElement("div");
  item.className = "item cloned";
  item.innerHTML = html;

  item.querySelector(".item_content").insertAdjacentHTML(
    "beforeend",
    `
    <div class="count">
      <input type="number" value="1" min="1">
      <div>총: <span class="total">0</span> 원</div>
    </div>
    `,
  );
  item.querySelector("input").oninput = priceChange;

  item.draggable = true;
  item.ondragstart = (ev) => ev.dataTransfer.setData("removeId", id);

  drop.appendChild(item);
  priceChange();
};

document.body.ondrop = (e) => {
  const id = e.dataTransfer.getData("removeId");
  if (!id || e.target.closest(".drop")) return;

  const cartItem = $(`.drop .item:has(img[alt="${id}"])`);
  if (cartItem) cartItem.remove();

  const origin = $(`.non-user-container .item:has(img[alt="${id}"])`);
  if (origin) origin.style.opacity = 1;

  priceChange();
};

document.body.ondragover = (e) => e.preventDefault();

function category(name, el) {
  $$(".cate div").forEach((v) => v.classList.remove("active"));
  el.classList.add("active");
  // 비회원 주문 HTML(데이터 값을 data.json 을 통해서 가져 오는것 포함해서 말하는것임)
  fetch("./data.json")
    .then((r) => r.json())
    .then((data) => {
      const container = $(".non-user-container .product-container");
      container.innerHTML = "";

      Object.values(data[name]).forEach((v, i) => {
        container.insertAdjacentHTML(
          "beforeend",
          `<div class="item">
            <div class="img-cover">
              <img src="./선수제공파일/A-Module/images/${name}/${
                i + 1
              }.PNG"alt="${name}/${i}">
            </div>
            <div class="item_content">
              <div class="item-title">${v.title}</div>
              <div class="item-price">
                <span class="price">${v.price}</span>
                ${
                  v.dis !== "0"
                    ? `<span style="text-decoration:line-through;color:gray">${v.dis}</span>`
                    : ""
                }
              </div>
            </div>
          </div>`,
        );
      });
      giveDrag();
    });
}
// 가격 변수
function priceChange() {
  let total = 0;

  $$(".drop .item").forEach((item) => {
    const price = +item.querySelector(".price").textContent.replace(/\D/g, "");
    const count = +item.querySelector("input").value || 0;
    const cost = price * count;

    item.querySelector(".total").textContent = cost.toLocaleString();
    total += cost;
  });

  $(".total span").textContent = total.toLocaleString();
}

// 알림
$(".checoutBtn").onclick = () => {
  if ($(".total span").textContent === "0") {
    alert("물건을 선택해주세요");
    return;
  }

  $(".user-alert").style.display = "block";
  $(".user-name").textContent = userId.textContent.replace("ID:  ", "");
  $(".cost").textContent = $(".total span").textContent;

  drop.innerHTML = "";
  category("건강식품", $(".active"));
  closeModal();

  setTimeout(() => ($(".user-alert").style.display = "none"), 3000);
};

category("건강식품", $(".active"));

async function addCart(idx, user) {
  const res = await fetch(`../addCart.php?idx=${idx}&user=${user}`);

  const data = await res.text();

  console.log(data);
}
