<?php

namespace common\mail\compositions;

use common\dataSet\Registration\ForumChargeInfo;
use common\service\Registration;

class CommonTemplate
{
    public function dropLines(int $height = 15): string
    {
        return "<tr><td style='font-size: 0; line-height: 0;' height='{$height}'>&nbsp;</td></tr>";
    }
    public function drawLines(int $height = 15): string
    {
        return "<td style='font-size: 0; line-height: 0;border-bottom:1px solid #d8d8d8;' height='{$height}'>&nbsp;</td>";
    }
    public function getRefundTemplate(): string
    {
        return "
        <tr><td style='font-size:20px;font-weight:600;color:#dc1c4d;'>환불 및 취소 정책</td></tr>
        {$this->dropLines(10)}
        <tr>
            <td>
                <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                    <tbody>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:50%;border-top:2px solid #363636;margin-top:2px;border-right:1px solid #d8d8d8;text-align:center'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;'>" . date('Y년 m월 d일', strtotime(REFUND_ABLE_END_DATE)) . " 까지</span></td>
                            <td align='center' bgcolor='f5f5f5' style='width:50%;border-top:2px solid #363636;text-align:center;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . date('Y년 m월 d일', strtotime(REFUND_UNABLE_START_DATE)) . " 이후</span></td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#FFFFFF' style='width:50%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:center;border-right:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;'>환불가능 (수수료 제외)</span></td>
                            <td align='center' bgcolor='FFFFFF' style='width:50%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:center;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>환불불가</span></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <ul style='padding-left:15px'>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>신청 취소 및 환불을 원하시는 경우, 사무국(02-2000-2620~3)으로 연락 주신 후 환불요청서를 이메일(wkf_reg@mk.co.kr, registration@wkforum.org)로 보내주시기 바랍니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>참가비 환불은 행사 종료 후 진행됩니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>환불 시 발생되는 수수료는 참가자 부담입니다.</p>
                    </li>

                </ul>
            </td>
        </tr>
        ";
    }
    public function getFooterTemplate(): string
    {
        return "
        <tr>
            <td align='center'>
                <img src='https://file.mk.co.kr/wkforum/img/footer_kor.png'  usemap='#link' alt='' width='850' height='194' style='display:block;'>
                <map name='link'>
                    <area shape='rect' coords='276,104,569,145' target='_blank' href='https://wkforum.org/' style='outline:0;'></map>
            </td>
        </tr>
        ";
    }
    public function getChargeTemplate(ForumChargeInfo $charge): string
    {
        return "
        <tr><td style='font-size:20px;font-weight:600;color:#dc1c4d;'>담당자 정보</td></tr>
        {$this->dropLines(10)}
        <tr>
            <td>
                <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                    <tbody>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>이름</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_name()}</span></td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>직장명</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_affiliation()}</span></td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>전화 연락처</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_phone()}</span></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>";
    }
    public function getPayTemplate(ForumChargeInfo $charge, array $members, string $lang, bool $isConfirmPayDate = false): string
    {
        $confirmPayDateTemplate = $isConfirmPayDate
            ? "<tr>
                <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>결제확인일</span></td>
                <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . date('Y. m. d') . "</span></td>
                </tr>"
            : "";

        return "
        <tr><td style='font-size:20px;font-weight:600;color:#dc1c4d;'>결제 정보</td></tr>
        {$this->dropLines(10)}
        <tr>
            <td>
                <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                    <tbody>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>등록카테고리</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . Registration::REG_NAME[$lang][$members[0][0]->getRegistry_cost_num()] . "</span></td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>등록인원수</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'>
                                <span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . count($members) . "명</span>
                            </td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>참가비</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . number_format($charge->getD_reg_amount()) . "원</span></td>
                        </tr>
                        <tr>
                            <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>결제방법</span></td>
                            <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . Registration::getBillTypeString($charge->getD_bill_type(), $charge->getD_bill_date()) . "</span></td>
                        </tr>

                        {$confirmPayDateTemplate}
                    </tbody>
                </table>
            </td>
        </tr>
        {$this->dropLines(5)}
        <tr>
            <td>
                <ul style='padding-left:15px'>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>할인대상자인 경우, 해당하는 증빙 서류를 이메일(wkf_reg@mk.co.kr, registration@wkforum.org)로 제출하여 주시기 바랍니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>은행 송금 수수료는 참가자 부담입니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>입금예정일까지 참가비를 납부하지 않은 경우 신청이 자동 취소되는 점 양해 부탁드립니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>참가비 전액 납부가 확인 된 후 최종 등록완료 안내 메일이 발송됩니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>만일 납부 후 1주일 내에 이메일을 받지 못하셨다면 사무국(02-2000-2620~3)로 연락 부탁드립니다.</p>
                    </li>
                    <li style='font-size:10px;color:#dc1c4d;'>
                        <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>프로그램은 주최측의 사정에 따라 변경될 수 있습니다.</p>
                    </li>
                </ul>
            </td>
        </tr>";
    }
}
