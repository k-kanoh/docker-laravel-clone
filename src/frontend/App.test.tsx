import { render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import App from "./App";

function getButtonColors() {
  const b = screen.getByTestId("bButtons").querySelectorAll("button");
  const s = screen.getByTestId("sButtons").querySelectorAll("button");
  const o = screen.getByTestId("oButtons").querySelectorAll("button");

  return [...b, ...s, ...o]
    .map(({ className }) => className.match(/bg-(\w+)/)?.[1] ?? "")
    .map((x) => (x === "gray" ? "x" : x[0]))
    .join("");
}

describe("App", () => {
  test("初期状態が正しく表示されること", () => {
    render(<App />);
    expect(getButtonColors()).toBe("xxxxxxxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 0球")).toBeInTheDocument();
  });

  test("ボールをクリックするとボールカウントが増える", async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");

    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("gxxxxxxx");
    expect(screen.getByText("バッター: 1球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 1球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("ggxxxxxx");
    expect(screen.getByText("バッター: 2球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 2球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("gggxxxxx");
    expect(screen.getByText("バッター: 3球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
  });

  test("3ボールからフォアボール", async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");

    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("gxxxxxxx");
    expect(screen.getByText("バッター: 1球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 1球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("ggxxxxxx");
    expect(screen.getByText("バッター: 2球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 2球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("gggxxxxx");
    expect(screen.getByText("バッター: 3球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("xxxxxxxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 4球")).toBeInTheDocument();
  });

  test("ストライクをクリックするとストライクカウントが増える", async () => {
    render(<App />);
    const s = screen.getByTestId("sButtons").querySelectorAll("button");

    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyxxxx");
    expect(screen.getByText("バッター: 1球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 1球")).toBeInTheDocument();
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyyxxx");
    expect(screen.getByText("バッター: 2球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 2球")).toBeInTheDocument();
  });

  test("2ストライクからファウル", async () => {
    render(<App />);
    const s = screen.getByTestId("sButtons").querySelectorAll("button");

    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyxxxx");
    expect(screen.getByText("バッター: 1球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 1球")).toBeInTheDocument();
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyyxxx");
    expect(screen.getByText("バッター: 2球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 2球")).toBeInTheDocument();
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyyxxx");
    expect(screen.getByText("バッター: 3球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxyyxxx");
    expect(screen.getByText("バッター: 4球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 4球")).toBeInTheDocument();
  });

  test("アウトをクリックするとアウトカウントが増える", async () => {
    render(<App />);
    const o = screen.getByTestId("oButtons").querySelectorAll("button");

    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 1球")).toBeInTheDocument();
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrrx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 2球")).toBeInTheDocument();
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
  });

  test("アウトをクリックするとカウントリセット", async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");
    const s = screen.getByTestId("sButtons").querySelectorAll("button");
    const o = screen.getByTestId("oButtons").querySelectorAll("button");

    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(s[0]);
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("gggyyxxx");
    expect(screen.getByText("バッター: 5球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 5球")).toBeInTheDocument();
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 6球")).toBeInTheDocument();
  });

  test("3アウトではカウントロック", async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");
    const s = screen.getByTestId("sButtons").querySelectorAll("button");
    const o = screen.getByTestId("oButtons").querySelectorAll("button");
    const hitButton = screen.getByRole("button", { name: /ヒット等/ });

    await userEvent.click(o[0]);
    await userEvent.click(o[0]);
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(b[0]);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(hitButton);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
  });

  test("3アウトでアウトをクリックするとオールリセット", async () => {
    render(<App />);
    const o = screen.getByTestId("oButtons").querySelectorAll("button");

    await userEvent.click(o[0]);
    await userEvent.click(o[0]);
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxrrr");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 3球")).toBeInTheDocument();
    await userEvent.click(o[0]);
    expect(getButtonColors()).toBe("xxxxxxxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 0球")).toBeInTheDocument();
  });

  test('"ヒット等"ボタンをクリックするとカウントリセット', async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");
    const s = screen.getByTestId("sButtons").querySelectorAll("button");
    const hitButton = screen.getByRole("button", { name: /ヒット等/ });

    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(s[0]);
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("gggyyxxx");
    expect(screen.getByText("バッター: 5球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 5球")).toBeInTheDocument();
    await userEvent.click(hitButton);
    expect(getButtonColors()).toBe("xxxxxxxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 6球")).toBeInTheDocument();
  });

  test('"Reset"ボタンをクリックするとオールリセット', async () => {
    render(<App />);
    const b = screen.getByTestId("bButtons").querySelectorAll("button");
    const s = screen.getByTestId("sButtons").querySelectorAll("button");
    const o = screen.getByTestId("oButtons").querySelectorAll("button");
    const resetButton = screen.getByRole("button", { name: /Reset/ });

    await userEvent.click(o[0]);
    await userEvent.click(o[0]);
    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(b[0]);
    await userEvent.click(s[0]);
    await userEvent.click(s[0]);
    expect(getButtonColors()).toBe("gggyyrrx");
    expect(screen.getByText("バッター: 5球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 7球")).toBeInTheDocument();
    await userEvent.click(resetButton);
    expect(getButtonColors()).toBe("xxxxxxxx");
    expect(screen.getByText("バッター: 0球")).toBeInTheDocument();
    expect(screen.getByText("イニング: 0球")).toBeInTheDocument();
  });
});
